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

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)
  },

  render: async () => {

  },

  createCampaign: async (data) => {
    let current_account;
    App.getAccounts(function (result) {
        current_account = result[0];

    });
    let campaign_name = $('[name="campaign_name"]').val();
    let target_contribution_amount = $('[name="target_contribution_amount"]').val();
    let minimum_contribution = $('[name="minimum_contribution"]').val();
    let description = $('[name="description"]').val();
    let date_start = $('[name="date_start"]').val();
    let date_end = $('[name="date_end"]').val();
    // let main_pic = $('[name="campaign_main_pic"]').val();
    // let img_path = main_pic.substring(12);

    // let description = $('textarea#description').val();
    // console.log(campaign_name, minimum_contribution, date_start, date_end);
    var currentdate = new Date(); 
    var datetime = String(currentdate.getDate() )
                    + String(currentdate.getMonth()+1)
                    + String(currentdate.getFullYear())
                    + String(currentdate.getHours() )
                    + String(currentdate.getMinutes())
                    + String(currentdate.getSeconds());
    datetime = Number(datetime)
    let newContractRequestId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);
    console.log(newContractRequestId)
    // console.log(main_pic)
    // console.log(img_path)
    await App.campaignfactory.requestToOpenCampaign(newContractRequestId,Number(minimum_contribution))
      .then((result) => {

        toastr.success("Successfully create request to open campaign");
        $('[name="donation_amount"]').val('');
        $('[name="campaign_name"]').val('');
        $('[name="target_contribution_amount"]').val('');
        $('[name="minimum_contribution"]').val('');
        $('[name="description"]').val('');
        $('[name="date_start"]').val('');
        $('[name="date_end"]').val('');

        axios.post(('/api/store-blockchain-request'), {
          "request_id": newContractRequestId,
          "amount": minimum_contribution,
          "request_type": 1,
          "requested_user_address":current_account,
          "target_contribution_amount":target_contribution_amount,
          "campaign_name":campaign_name,
          "date_start":date_start,
          "date_end":date_end,
          "description": description,
          // "main_pic": img_path
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully store new validated request in database');
            window.location.href = "list-request";
          } else {
            console.log('UnSuccessfully store new validated request in database');
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

}


$(window).on('load', function () {
  App.load()

});

// console.log(WALLET_TYPE)