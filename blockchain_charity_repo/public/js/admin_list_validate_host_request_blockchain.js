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

  },

  loadContract: async () => {
    const campaignfactory = await $.getJSON('/contracts/CampaignFactory.json')
    // console.log(campaignfactory)
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)

    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)

    //const current_account =  await web3.eth.getCoinbase();

//    if(current_account != USER_ADDRESS.toLowerCase()){
//      window.alert("Please use account "+USER_ADDRESS+" //in metamask.")
//    }
    // let accounts_ = await web3.eth.getAccounts();
    // console.log(accounts_);
  },

  render: async () => {

    await App.renderAllRequestValidateHost(); 
  },

  renderAllRequestValidateHost: async () => {


    const totalRequestValidateHost = await App.campaignfactory.getRequestToBeHostList();
    // console.log(totalRequestValidateHost);
    const campaignTemplate = $('#recentRequestValidateHost');
    campaignTemplate.html('');

    for (let  i = 0; i < totalRequestValidateHost.length; i++) {
      // let temp = await App.campaignfactory.getRequestInRequestToBeHostListAtIndex(i);
      
      // console.log(temp[0]);
      // console.log(temp[1].toNumber());

      let campaignItem =
          `<div class="col-md-12">
            <form>
              <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">REQUEST VALIDATE HOST #${i + 1}</h5>
                  </div>
                  <div class="card-body">
                      <h6 class="card-subtitle mb-2"><span class="text-muted">Requested Account Address:</span> `+ totalRequestValidateHost[i] +`</h6>
                  </div>
                  <div class="card-footer">
                    <a type="button" class="btn btn-success text-light" onclick="App.responseRequestValidateHost('`+totalRequestValidateHost[i]+`',true); return false"> ?????ng ?? </a>
                    <a type="button" class="btn btn-danger text-light" onclick="App.responseRequestValidateHost('`+totalRequestValidateHost[i]+`',false); return false"> T??? ch???i </a>
                  </div>
              </div>
            </form>
          </div>`;
      // Show the task
      campaignTemplate.append(campaignItem)
    }
  },
  responseRequestValidateHost: async (requestedAccountAddress, response) => {
    if(response == true){
      await App.campaignfactory.validateHost(requestedAccountAddress)
      .then((result) => {
        // console.log(result);
        // const campaign_contract_address = result.logs[0].args.new_campaign_address;
        // const minimum_contribution = result.logs[0].args.minimum_contribution.toNumber();
        // const host_address = result.logs[0].args.host;
        // const admin_address = result.logs[0].args.admin;
        // // const minimum_contribution = donateValueId;
        
        // console.log(campaign_contract_address,minimum_contribution,host_address,admin_address);
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully validated host: '+requestedAccountAddress,
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestedAccountAddress,
          "decide_type": "Accept",
          "request_type" : 0
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully accept new validated host: '+requestedAccountAddress);
          } else {
            console.log('UnSuccessfully accept new validated host: '+requestedAccountAddress);
          }
        })
        App.renderAllRequestValidateHost();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
   
      
    } else {
      await App.campaignfactory.rejectValidateRequestHost(requestedAccountAddress)
      .then((result) => {
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Reject Host validate request',
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestedAccountAddress,
          "decide_type": "Decline",
          "request_type" : 0
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully reject new validated host: '+requestedAccountAddress);
          } else {
            console.log('UnSuccessfully reject new validated host: '+requestedAccountAddress);
          }
        })
        App.renderAllRequestValidateHost();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });

    }
    
  },

}


$(window).on('load', function () {
  App.load()
});