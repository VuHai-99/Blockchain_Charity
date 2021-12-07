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
    //const current_account =  await web3.eth.getCoinbase();

//    if(current_account != USER_ADDRESS.toLowerCase()){
//      window.alert("Please use account "+USER_ADDRESS+" //in metamask.")
//    }

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
  loadContract: async () => {
    const campaignfactory = await $.getJSON('/contracts/CampaignFactory.json')
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)
    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    // console.log();

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)
  },

  render: async () => {

  },

  requestToCreateDonationActivityCashout: async () => {
    let current_account;
    App.getAccounts(function (result) {
        current_account = result[0];
    });
    let donation_activity_address = $('[name="donation_activity_address"]').val();
    let cashout_value = $('[name="cashout_value"]').val();
    let campaign_address = $('[name="campaign_address"]').val();

    var currentdate = new Date(); 
    var datetime = String(currentdate.getDate() )
                    + String(currentdate.getMonth()+1)
                    + String(currentdate.getFullYear())
                    + String(currentdate.getHours() )
                    + String(currentdate.getMinutes())
                    + String(currentdate.getSeconds());
    datetime = Number(datetime)
    let newContractRequestId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);


    let b = App.contracts.Campaign.at(campaign_address);
    await b.requestToCreateCashOutFromDonationActivity(newContractRequestId,cashout_value,donation_activity_address)
      .then((result) => {

        toastr.success("Successfully create request to cash out in donation activity");
        $('[name="donation_activity_address"]').val('');
        $('[name="cashout_value"]').val('');
        
        axios.post(('/api/store-blockchain-request'), {
          "request_id": newContractRequestId,
          "request_type": 4,
          "requested_user_address":current_account,
          "donation_activity_address":donation_activity_address,
          "amount":cashout_value
          // "main_pic": img_path
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully create request to cash out request in database');
          } else {
            console.log('UnSuccessfully create request to cash out request in database');
          }
        })
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

// console.log(WALLET_TYPE)