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

    
    const totalCampaign = await App.campaignfactory.getCampaignList();
    // console.log(totalRequestOpenCampaign);
    const campaignTemplate = $('#confirmOrder');
    campaignTemplate.html('');
    for (let  i = 0; i < totalCampaign.length; i++) {
      let b =  await App.contracts.Campaign.at(totalCampaign[i]);
      let totalDonationActivity = await b.getDonationActivityList();
     
        
      for(let k=0; k<totalDonationActivity.length;k++){
        let c =  await App.contracts.DonationActivity.at(totalDonationActivity[k]);
        let totalOrder = await c.getOrderList();

        // console.log(totalOrder);

        for(let j = 0; j < totalOrder.length;j++){
          let order = await c.getOrderByCode(totalOrder[j]);
          // console.log(order);
          let orderState =order[3].toNumber();
          if(orderState == 0){  
            let campaignItem =
            `<div class="col-md-12">
              <form>
                <div class="card mt-4">
                    <div class="card-header">
                      <h5 class="card-title">Order mua hàng đợt từ thiện</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                        <hr>
                        <h6 class="card-subtitle mb-2"><span class="text-muted">Order Bytes32 ID:</span> `+ totalOrder[j] +`</h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Campaign: `+ totalCampaign[i] +`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Donation Activity: `+ totalDonationActivity[k] +`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Receipt URL: `+ order[1]+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Total Amout: `+ (order[0].toNumber()).toString()+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Order State: `+ (order[3].toNumber()).toString()+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Authority Confirmation: `+ order[4]+`</span></h6>
                    </div>
                    <div class="card-footer">
                      <a type="button" class="btn btn-success text-light" onclick="App.retailerDecideOrder('`+totalOrder[j]+`','`+totalDonationActivity[k]+`',true); return false"> Đồng ý </a>
                      <a type="button" class="btn btn-danger text-light" onclick="App.retailerDecideOrder('`+totalOrder[j]+`','`+totalDonationActivity[k]+`',false); return false"> Từ chối </a>
                      
                    </div>
                </div>
              </form>
            </div>`;    
            campaignTemplate.append(campaignItem);
          } else if(orderState == 1){
            let campaignItem =
            `<div class="col-md-12">
              <form>
                <div class="card mt-4">
                    <div class="card-header">
                      <h5 class="card-title">Order đã confirm</h5>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                        <hr>
                        <h6 class="card-subtitle mb-2"><span class="text-muted">Order Bytes32 ID:</span> `+ totalOrder[j] +`</h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Campaign: `+ totalCampaign[i] +`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Donation Activity: `+ totalDonationActivity[k] +`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Receipt URL: `+ order[1]+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Total Amout: `+ (order[0].toNumber()).toString()+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Order State: `+ (order[3].toNumber()).toString()+`</span></h6>
                        <h6 class="card-subtitle mb-2" ><span class="text-muted">Authority Confirmation: `+ order[4]+`</span></h6>
                    </div>
                    <div class="card-footer">
                    
                    </div>
                </div>
              </form>
            </div>`; 
            campaignTemplate.append(campaignItem);   
          }

          
          
        }
        // console.log(request.toNumber())
        // console.log(request);

        

      }
      
      // console.log(temp[1].toNumber());

      
    }
  },
  retailerDecideOrder: async (requestIdBytes32,donationActivityAddress, response) => {
    if(response == true){
      let c =  await App.contracts.DonationActivity.at(donationActivityAddress);
      await c.retailerConfirmDeliveryOrder(requestIdBytes32)
      .then((result) => {
        // console.log(result.logs[0]);
        // const newDonationActivityAddress = result.logs[0].args.new_campaign_address;

        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Accept Order',
          confirmButtonText: 'Close'
        })

        axios.post(('/api/confirm-donation-activity-request'), {
          "orderID": orderID,
          "request_type": 'retailer-confirm-delivering'
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully authority confirm order in database');
          } else {
            console.log('UnSuccessfully authority confirm order in database');
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
   
      
    } else {
      let c =  await App.contracts.DonationActivity.at(donationActivityAddress);
      await c.cancelOrder(requestIdBytes32)
      .then((result) => {
        // console.log(result.logs[0]);
        // const newDonationActivityAddress = result.logs[0].args.new_campaign_address;

        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Deline Order',
          confirmButtonText: 'Close'
        })
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