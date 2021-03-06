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

  loadContract: async () => {
    const campaignfactory = await $.getJSON('/contracts/CampaignFactory.json')
    // console.log(campaignfactory)
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)

    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)

    // let accounts_ = await web3.eth.getAccounts();
    // console.log(accounts_);
  },

  render: async () => {

    await App.renderAllRequestCreateDonationActivityOrder(); 
  },

  renderAllRequestCreateDonationActivityOrder: async () => {

    
    const totalCampaign = await App.campaignfactory.getCampaignList();
    // console.log(totalRequestOpenCampaign);
    const campaignTemplate = $('#recentRequestCreateDonationActivityOrder');
    campaignTemplate.html('');
    for (let  i = 0; i < totalCampaign.length; i++) {
      let b =  await App.contracts.Campaign.at(totalCampaign[i]);
      let totalRequestToCreateDonationActivityOrder = await b.getRequestToCreateOrderFromDonationActivityList();
     
        
      for(let k=0; k<totalRequestToCreateDonationActivityOrder.length;k++){
        let request = await b.getRequestToCreateOrderFromDonationActivity(totalRequestToCreateDonationActivityOrder[k]);
        // console.log(request.toNumber())
        // console.log(request);
        let campaignItem =
          `<div class="col-md-12">
            <form>
              <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">REQUEST T???O ORDER TRONG ?????T T??? THI???N</h5>
                  </div>
                  <div class="card-body">
                      <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                      <hr>
                      <h6 class="card-subtitle mb-2"><span class="text-muted">Request Bytes32 ID:</span> `+ totalRequestToCreateDonationActivityOrder[k] +`</h6>
                      <h6 class="card-subtitle mb-2" ><span class="text-muted">Campaign: `+ totalCampaign[i] +`</span></h6>
                      <h6 class="card-subtitle mb-2" ><span class="text-muted">Donation Activity: `+ request[0] +`</span></h6>
                      <h6 class="card-subtitle mb-2" ><span class="text-muted">Retailer: `+ request[1] +`</span></h6>
                      <h6 class="card-subtitle mb-2" ><span class="text-muted">Receipt URL: `+ request[2] +`</span></h6>
                      <h6 class="card-subtitle mb-2" ><span class="text-muted">Order Amount: `+ (request[3].toNumber()).toString()+`</span></h6>
                  </div>
                  <div class="card-footer">
                    <a type="button" class="btn btn-success text-light" onclick="App.responseRequestCreateDonationActivityOrder('`+totalRequestToCreateDonationActivityOrder[k]+`','`+totalCampaign[i]+`','`+request[0]+`',true); return false"> ?????ng ?? </a>
                    <a type="button" class="btn btn-danger text-light" onclick="App.responseRequestCreateDonationActivityOrder('`+totalRequestToCreateDonationActivityOrder[k]+`','`+totalCampaign[i]+`','`+request[0]+`',false); return false"> T??? ch???i </a>
                  </div>
              </div>
            </form>
          </div>`;    
          campaignTemplate.append(campaignItem) ;
      }
      
      // console.log(temp[1].toNumber());

      
    }
  },
  responseRequestCreateDonationActivityOrder: async (requestIdBytes32,campaignAddress,donationActivity, response) => {
    if(response == true){
      let b =  await App.contracts.Campaign.at(campaignAddress);
      await b.newOrderFromDonationActivity(requestIdBytes32)
      .then((result) => {
        // console.log(result.logs[0]);
        // const newDonationActivityAddress = result.logs[0].args.new_campaign_address;

        Swal.fire({
          title: 'Successful!',
          text: 'Successfully create donation activity order',
          confirmButtonText: 'Close'
        })


        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestIdBytes32,
          "decide_type": "Accept",
          "donation_activity_address": donationActivity,
          "request_type" : 5
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully create donation activity order in database');
          } else {
            console.log('UnSuccessfully create donation activity order in database');
          }
        })
        let syncBalanceCampaignUrl = '/api/sync/balance/campaign/'.concat(campaignAddress);
        axios.get((syncBalanceCampaignUrl));
        App.renderAllRequestCreateDonationActivityOrder();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
   
      
    } else {
      let b =  await App.contracts.Campaign.at(campaignAddress);
      await b.cancelOrderFromDonationActivity(requestIdBytes32)
      .then((result) => {
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Reject create donation activity Order',
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestIdBytes32,
          "decide_type": "Decline",
          "request_type" : 5
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully Reject create donation activity in database');
          } else {
            console.log('UnSuccessfully Reject create donation activity in database');
          }
        })
        App.renderAllRequestCreateDonationActivityOrder();
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