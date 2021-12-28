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
    // console.log(campaignfactory)
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)

    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)

    const donationactivity = await $.getJSON('/contracts/DonationActivity.json')
    App.contracts.DonationActivity = TruffleContract(donationactivity)
    App.contracts.DonationActivity.setProvider(App.web3Provider)

    // let accounts_ = await web3.eth.getAccounts();
    // console.log(accounts_);
  },

  render: async () => {

    await App.renderAllRequestCreateDonationActivityCashout(); 
  },

  renderAllRequestCreateDonationActivityCashout: async () => {
    let current_authority;
    App.getAccounts(function (result) {
        current_authority = result[0];
    });
    
    const totalCampaign = await App.campaignfactory.getCampaignList();
    // console.log(totalRequestOpenCampaign);
    const campaignTemplate = $('#recentRequestCashoutDonationActivity');
    campaignTemplate.html('');
    for (let  i = 0; i < totalCampaign.length; i++) {
      // console.log(totalCampaign[i]);
      let b =  await App.contracts.Campaign.at(totalCampaign[i]);
      let totalDonationActivity = await b.getDonationActivityList();
     
      for(let j=0; j<totalDonationActivity.length;j++){
        let c = await App.contracts.DonationActivity.at(totalDonationActivity[j]);
        console.log(totalDonationActivity[j]);
        let author = await c.getAuthority();
        if(author === current_authority){
          let totalCashout = await c.getCashOutList();
          for(let k=0; k<totalCashout.length;k++){
            
            let cashout = await c.getCashOutByCode(totalCashout[k]);
            let hostAddress = await c.getHost();
            // console.log(cashout.toNumber())
            console.log(cashout);
            if(cashout[1] == true){
              let campaignItem =
              `<div class="col-md-12">
                <form>
                  <div class="card mt-4">
                      <div class="card-header">
                        <h5 class="card-title">REQUEST CASHOUT ĐỢT TỪ THIỆN <b>(Finished)</b></h5>
                      </div>
                      <div class="card-body">
                          <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                          <hr>
                          <h6 class="card-subtitle mb-2"><span class="text-muted">Cashout Request Bytes32 ID:</span> `+ totalCashout[k] +`</h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Campaign Address: `+ totalCampaign[i] +`</span></h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Donation Activity Address: `+ totalDonationActivity[j] +`</span></h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Cashout Amount: `+ (cashout[0].toNumber()).toString()+`</span></h6>
                      </div>
                  </div>
                </form>
              </div>`;    
              campaignTemplate.append(campaignItem) ;
            } else {
              let campaignItem =
              `<div class="col-md-12">
                <form>
                  <div class="card mt-4">
                      <div class="card-header">
                        <h5 class="card-title">REQUEST CASHOUT ĐỢT TỪ THIỆN</h5>
                      </div>
                      <div class="card-body">
                          <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                          <hr>
                          <h6 class="card-subtitle mb-2"><span class="text-muted">Cashout Request Bytes32 ID:</span> `+ totalCashout[k] +`</h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Campaign Address: `+ totalCampaign[i] +`</span></h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Donation Activity Address: `+ totalDonationActivity[j] +`</span></h6>
                          <h6 class="card-subtitle mb-2" ><span class="text-muted">Cashout Amount: `+ (cashout[0].toNumber()).toString()+`</span></h6>
                      </div>
                      <div class="card-footer">
                        <a type="button" class="btn btn-success text-light" onclick="App.responseRequestCashoutDonationActivityCashout('`+totalCashout[k]+`','`+totalDonationActivity[j]+`','`+hostAddress+`',true); return false"> Đồng ý </a>
                        <a type="button" class="btn btn-danger text-light" onclick=""> Từ chối </a>
                      </div>
                  </div>
                </form>
              </div>`;    
              campaignTemplate.append(campaignItem) ;
            }
  
  
            
          }
        }
        
      }
     
      
      // console.log(temp[1].toNumber());

      
    }
  },
  responseRequestCashoutDonationActivityCashout: async (cashoutID,donationActivity,hostAddress, response) => {
    if(response == true){
      let c =  await App.contracts.DonationActivity.at(donationActivity);
      await c.authorityConfirmReceivedCashOut(cashoutID)
      .then((result) => {
        console.log(result);
        // const newDonationActivityAddress = result.logs[0].args.new_campaign_address;

        Swal.fire({
          title: 'Successful!',
          text: 'Successfully create donation activity cashout',
          confirmButtonText: 'Close'
        })


        axios.post(('/api/decide-cashout-request'), {
          "cashoutID": cashoutID,
          "decide": true
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully authority confirm cashout in database');
          } else {
            console.log('UnSuccessfully authority confirm cashout in database');
          }
        })
        let syncBalanceAccountUrl = '/api/sync/balance/account/'.concat(hostAddress);
        axios.get((syncBalanceAccountUrl));
        App.renderAllRequestCreateDonationActivityCashout();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
   
      
    } else {
      // let b =  await App.contracts.Campaign.at(campaignAddress);
      // await b.cancelCashOutFromDonationActivity(cashoutID)
      // .then((result) => {
      //   Swal.fire({
      //     title: 'Successful!',
      //     text: 'Successfully Reject create donation activity Cashout',
      //     confirmButtonText: 'Close'
      //   })
      //   axios.post(('/api/decide-blockchain-request'), {
      //     "request_id": requestIdBytes32,
      //     "decide_type": "Decline",
      //     "request_type" : 4
      //   }).then(function(response){
      //     if(response.status == 200){
      //       console.log('Successfully Reject create donation activity in database');
      //     } else {
      //       console.log('UnSuccessfully Reject create donation activity in database');
      //     }
      //   })
      //   App.renderAllRequestCreateDonationActivityCashout();
      // }).catch(error => {
      //   Swal.fire({
      //     title: 'Unsuccessful!',
      //     text: error.message,
      //     icon: 'error',
      //     confirmButtonText: 'Close'
      //   })
      // });
    }
    
  },

}


$(window).on('load', function () {
  App.load()
});