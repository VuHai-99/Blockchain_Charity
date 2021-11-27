App = {
  contracts: {},
  load: async () => {
    
    await App.loadWeb3()
    await App.loadAccount()
    await App.loadContract()
    await App.render()
  },

  loadWeb3: async () => {
    if (typeof web3 !== 'undefined') {
      App.web3Provider = web3.currentProvider
      web3 = new Web3(web3.currentProvider)
    } else {
      window.alert("Please connect to Metamask.")
    }
    // Modern dapp browsers...
    if (window.ethereum) {
      window.web3 = new Web3(ethereum)
      try {
        // Request account access if needed
        await ethereum.enable()
        // Acccounts now exposed
        web3.eth.sendTransaction({/* ... */})
      } catch (error) {
        // User denied account access...
      }
    }
    // Legacy dapp browsers...
    else if (window.web3) {
      App.web3Provider = web3.currentProvider
      window.web3 = new Web3(web3.currentProvider)
      // Acccounts always exposed
      web3.eth.sendTransaction({/* ... */})
    }
    // Non-dapp browsers...
    else {
      console.log('Non-Ethereum browser detected. You should consider trying MetaMask!')
    }
  },

  loadAccount: async () => {
    // Set the current blockchain account
    web3.eth.defaultAccount = ethereum._state.accounts[0]
    App.account = web3.eth.accounts[0]
    // console.log('accounts', web3.eth.accounts);
    const current_account =  await web3.eth.getCoinbase();

    if(current_account != USER_ADDRESS.toLowerCase()){
      window.alert("Please use account "+USER_ADDRESS+" in metamask.")
    }
  },

  loadContract: async () => {
    const campaignfactory = await $.getJSON('/contracts/CampaignFactory.json')
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)

    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)
  },
  getAccounts: (callback) => {
    web3.eth.getAccounts((error, result) => {
        if (error) {
            console.log(error);
        } else {
            callback(result);
        }
    });
  },
  render: async () => {
    await App.renderValidateState();
  },
  renderValidateState: async () => {
    const validateState = await App.campaignfactory.hostValidateState();
    // console.log(validateState);
    const hostValidateTemplate = $('#hostValidate');
    hostValidateTemplate.html('');
    if(validateState.toNumber() == 0){
      let appendItem = 
        `<h3 class="my-4 text-left">Validate Account</h3>
        <p> Tài khoản host của bạn chưa được validate. </p>
        <br>
        <button class="btn btn-primary" onclick="App.requestForValidation(); return false">Request for Validation</button>`;
      hostValidateTemplate.append(appendItem);
    } else if(validateState.toNumber() == 1){
      let appendItem = 
        `<h3 class="my-4 text-left">Validate Account</h3>
        <p> Tài khoản host của bạn đang được validate. </p>
        <br>
        <button class="btn btn-info text-dark" disabled>Waiting for Validation</button>`;
      hostValidateTemplate.append(appendItem);
    } else if(validateState.toNumber() == 2){
      let appendItem = 
        `<h3 class="my-4 text-left">Validate Account</h3>
        <p> Tài khoản host của bạn đã validate. </p>
        <br>
        <button class="btn btn-success text-dark" disabled>Successful Validation</button>`;
      hostValidateTemplate.append(appendItem);
    }
  },
  requestForValidation: async (data) => {
    let current_account;
    App.getAccounts(function (result) {
        current_account = result[0];
    });
    await App.campaignfactory.requestToBeValidHost()
      .then((result) => {

        // Swal.fire({
        //   title: 'Successful!',
        //   text: 'Successful action',
        //   confirmButtonText: 'Close'
        // })
        toastr.success("Successfully create validate request");
        axios.post(('/api/store-blockchain-request'), {
          "request_id": current_account,
          "amount": "",
          "request_type": 0,
          "requested_user_address": current_account
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully store new validated request in database');
          } else {
            console.log('UnSuccessfully store new validated request in database');
          }
        })
        App.renderValidateState();
      }).catch(error => {   
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
        console.log(error)
      });
  },

}


$(window).on('load', function () {
  App.load()
});