
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

        // console.log('accounts', web3.eth.accounts);
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

        // let accounts_ = await web3.eth.getAccounts();
        // console.log(accounts_);
    },
    
    // isadmin:() =>{
        // let current_account;
        // App.getAccounts(function(result) {
        // current_account = result[0];
        // });
        
    // },
 
    donateCampaign: async (address) => {
      // let minimumContribution = $('[name="minimumContribution"]').val();
      let donateValue = $('[name="donation_amount"]').val();
  
      console.log(donateValue);
      
      let b = App.contracts.Campaign.at(address)
      //get minimumContribution
      // b.minimumContribution.call().then(function(response) {
      //   return console.log(response.c[0]);
      // })
  
  
      b.contribute({value:donateValue})
        .then(function(result){
          const sender_contract_address = result.receipt.from;
          const campaign_contract_address = result.receipt.to;
          const transaction_hash = result.receipt.transactionHash;
          const amount_in_wei = donateValue;
        //   console.log(result)
        toastr.success("Successfully donate to campaign");
        $('[name="donation_amount"]').val('');
        //   Swal.fire({
        //     title: 'Successful!',
        //     text: 'Successfully contribute to the campaign',
        //     confirmButtonText: 'Close'
        //   })
          axios.post(('/api/store-transaction'), {
            "transaction_hash": transaction_hash,
            "sender_address": sender_contract_address,
            "receiver_address": campaign_contract_address,
            "transaction_type" : 0,
            "amount":amount_in_wei
          }).then(function(response){
            if(response.status == 200){
              console.log('Successfully store donation info in database');
              location.reload();
            } else {
              console.log('UnSuccessfully store donation info in database');
            }
          })
          let syncBalanceAccountUrl = '/api/sync/balance/account/'.sender_contract_address;
          let syncBalanceCampaignUrl = '/api/sync/balance/campaign/'.campaign_contract_address;
          axios.get((syncBalanceAccountUrl));
          axios.get((syncBalanceCampaignUrl));
        }).catch(error => {
          Swal.fire({
            title: 'Unsuccessful!',  
            text: error.message,
            icon: 'error',
            confirmButtonText: 'Close'
          })
        });
      
    }
}

$(window).on('load', function () {
    App.load()
});
