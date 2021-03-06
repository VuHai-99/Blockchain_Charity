App = {
    contracts: {},
    load: async () => {
        
        await App.loadWeb3()
        await App.loadAccount()
        await App.loadContract()
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
                web3.eth.sendTransaction({
                    /* ... */ })
            } catch (error) {
                // User denied account access...
            }
        }
        // Legacy dapp browsers...
        else if (window.web3) {
            App.web3Provider = web3.currentProvider
            window.web3 = new Web3(web3.currentProvider)
            // Acccounts always exposed
            web3.eth.sendTransaction({
                /* ... */ })
        }
        // Non-dapp browsers...
        else {
            console.log('Non-Ethereum browser detected. You should consider trying MetaMask!')
        }
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
    loadAccount: async () => {
        // Set the current blockchain account
        web3.eth.defaultAccount = ethereum._state.accounts[0]
        App.account = web3.eth.accounts[0]

        // const current_account =  await web3.eth.getCoinbase();

        // if(current_account != USER_ADDRESS.toLowerCase()){
        //   window.alert("Please use account "+USER_ADDRESS+" in metamask.")
        // }

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
    
 
    cancelOpenCampaignRequest: async (request_id) => {

      // let b = App.contracts.Campaign.at(address);
      let current_account;
      App.getAccounts(function (result) {
          current_account = result[0];
  
      });
      await App.campaignfactory.cancelOpenCampaignRequest(request_id)
      .then((result) => {

        toastr.success("Successfully cancel request create new campaign");
        axios.post(('/api/store-blockchain-request'), {
          "request_id": request_id,
          "amount": "",
          "request_type": 0,
          "cancel" : true
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully cancel new validated request in database');
            location.reload();
          } else {
            console.log('UnSuccessfully cancel new validated request in database');
          }
        })
        let syncBalanceAccountUrl = '/api/sync/balance/account/'.concat(current_account);
        axios.get((syncBalanceAccountUrl));
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

    cancelOpenDonationCampaignRequest: async (request_id,campaign_address) => {
        let current_account;
        App.getAccounts(function (result) {
            current_account = result[0];
    
        });
        // let b = App.contracts.Campaign.at(address);
        let b = App.contracts.Campaign.at(campaign_address);
        await b.cancelCreateDonationActivityRequest(request_id)
        .then((result) => {
  
          toastr.success("Successfully cancel request create donation activity");

          let syncBalanceAccountUrl = '/api/sync/balance/account/'.concat(current_account);
          axios.get((syncBalanceAccountUrl));

          axios.post(('/api/store-blockchain-request'), {
            "request_id": request_id,
            "amount": "",
            "request_type": 3,
            "cancel" : true
          }).then(function(response){
            if(response.status == 200){
              console.log('Successfully cancel request create donation activity in database');
              location.reload();
            } else {
              console.log('UnSuccessfully cancel request create donation activity in database');
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

    cancelCreateDonationCampaignCashoutRequest: async (request_id,campaign_address) => {
        let current_account;
        App.getAccounts(function (result) {
            current_account = result[0];
    
        });
        // let b = App.contracts.Campaign.at(address);
        let b = App.contracts.Campaign.at(campaign_address);
        await b.cancelCashOutFromDonationActivity(request_id)
        .then((result) => {
  
          toastr.success("Successfully cancel request create donation activity cashout");
          let syncBalanceAccountUrl = '/api/sync/balance/account/'.concat(current_account);
          axios.get((syncBalanceAccountUrl));
          axios.post(('/api/store-blockchain-request'), {
            "request_id": request_id,
            "amount": "",
            "request_type": 4,
            "cancel" : true
          }).then(function(response){
            if(response.status == 200){
              console.log('Successfully cancel request create donation activity cashout in database');
              location.reload();
            } else {
              console.log('UnSuccessfully cancel request create donation activity cashout in database');
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

    cancelCreateDonationCampaignOrderRequest: async (request_id,campaign_address) => {
      let current_account;
      App.getAccounts(function (result) {
          current_account = result[0];
      });
      // let b = App.contracts.Campaign.at(address);
      let b = App.contracts.Campaign.at(campaign_address);
      await b.cancelOrderFromDonationActivity(request_id)
      .then((result) => {

        toastr.success("Successfully cancel request create donation activity order");
        let syncBalanceAccountUrl = '/api/sync/balance/account/'.concat(current_account);
        axios.get((syncBalanceAccountUrl));
        axios.post(('/api/store-blockchain-request'), {
          "request_id": request_id,
          "amount": "",
          "request_type": 5,
          "cancel" : true
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully cancel request create donation activity order in database');
            location.reload();
          } else {
            console.log('UnSuccessfully cancel request create donation activity order in database');
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
