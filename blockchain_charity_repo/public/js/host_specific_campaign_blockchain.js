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
    
 
    donateCampaign: async (address) => {
      // let minimumContribution = $('[name="minimumContribution"]').val();
      let donateValue = $('[name="donation_amount"]').val();
  
      // console.log(donateValue);
      
      // let b = App.contracts.Campaign.at(address).then((res) => {
      //   console.log(res.contribute({value:'1'}))
      // })
      // console.log(b)
      let b = App.contracts.Campaign.at(address);
  
      b.contribute({value:donateValue})
        .then(function(result){
          const sender_contract_address = result.receipt.from;
          const campaign_contract_address = result.receipt.to;
          const transaction_hash = result.receipt.transactionHash;
          const amount_in_wei = donateValue;
          console.log(result)
          toastr.success("Successfully donate to campaign");
          $('[name="donation_amount"]').val('')
          axios.post(('/api/store-transaction'), {
            "transaction_hash": transaction_hash,
            "sender_address": sender_contract_address,
            "receiver_address": campaign_contract_address,
            "transaction_type" : 0,
            "amount":amount_in_wei
          }).then(function(response){
            if(response.status == 200){
              console.log('Successfully store donation info in database');
            } else {
              console.log('UnSuccessfully store donation info in database');
            }
          })
        }).catch(error => {
          Swal.fire({
            title: 'Unsuccessful!',  
            text: error.message,
            icon: 'error',
            confirmButtonText: 'Close'
          })
        });
      
    },
    createWithdrawMoneyRequest: async (requestCampaignAddress) =>{
        // let minimumContribution = $('[name="minimumContribution"]').val();

      let current_account;
      App.getAccounts(function(result) {
      current_account = result[0];
      });
      let donateValue = $('[name="withdrawal_amount"]').val();

      var currentdate = new Date(); 
      var datetime = String(currentdate.getDate() )
                      + String(currentdate.getMonth()+1)
                      + String(currentdate.getFullYear())
                      + String(currentdate.getHours() )
                      + String(currentdate.getMinutes())
                      + String(currentdate.getSeconds());
      datetime = Number(datetime)
      let newWithdrawId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);
    //   console.log(newWithdrawId)
  
      await App.campaignfactory.requestToWithdrawMoney(newWithdrawId,Number(donateValue), requestCampaignAddress)
        .then((result) => {
  
          const request_id = newWithdrawId;
          const request_type = 2;
          const amount = donateValue;
          const campaign_address = requestCampaignAddress;
  
        //   console.log(request_id,request_type,amount,campaign_address,current_account)
          toastr.success("Successfully create withdraw money request");
          $('[name="withdrawal_amount"]').val('')
          // Swal.fire({
          //   title: 'Successful!',
          //   text: 'Successful action',
          //   confirmButtonText: 'Close'
          // })
          axios.post(('/api/store-blockchain-request'), {
            "request_id": request_id,
            "amount": amount,
            "request_type": request_type,
            "campaign_address": campaign_address,
            "requested_user_address": current_account
          }).then(function(response){
            if(response.status == 200){
              console.log('Successfully store new withdraw money request in database');
            } else {
              console.log('UnSuccessfully store new withdraw money request in database');
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
      
    }

}


$(window).on('load', function () {
    App.load()
});
