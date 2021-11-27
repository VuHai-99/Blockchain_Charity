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

    await App.renderAllRequestOpenCampaign(); 
  },

  renderAllRequestOpenCampaign: async () => {


    const totalRequestOpenCampaign = await App.campaignfactory.getRequestToOpenCampaignList();
    // console.log(totalRequestOpenCampaign);
    const campaignTemplate = $('#recentRequestOpenCampaigns');
    campaignTemplate.html('');
    for (let  i = 0; i < totalRequestOpenCampaign.length; i++) {
      let temp = await App.campaignfactory.getRequestToOpenCampaignListAtKey(totalRequestOpenCampaign[i]);
      
      // console.log(temp[0]);
      // console.log(temp[1].toNumber());

      let campaignItem =
          `<div class="col-md-12">
            <form>
              <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">REQUEST MỞ DỰ ÁN #${i + 1}</h5>
                  </div>
                  <div class="card-body">
                      <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i></strong></h4>
                      <hr>
                      <h6 class="card-subtitle mb-2"><span class="text-muted">Request Bytes32 ID:</span> `+ totalRequestOpenCampaign[i] +`</h6>
                      <h6 class="card-subtitle mb-2" id="host_${i}"><span class="text-muted">Request Host: `+ temp[0] +`</span></h6>
                      <h6 class="card-subtitle mb-2" id="minimumContribution_${i}"><span class="text-muted">Campaign Minimum Contribution: `+ temp[1].toNumber() +`</span></h6>
                  </div>
                  <div class="card-footer">
                    <a type="button" class="btn btn-success text-light" onclick="App.responseRequestOpenCampaign('`+totalRequestOpenCampaign[i]+`',true); return false"> Đồng ý </a>
                    <a type="button" class="btn btn-danger text-light" onclick="App.responseRequestOpenCampaign('`+totalRequestOpenCampaign[i]+`',false); return false"> Từ chối </a>
                  </div>
              </div>
            </form>
          </div>`;
      // Show the task
      campaignTemplate.append(campaignItem)
    }
  },
  responseRequestOpenCampaign: async (requestIdBytes32, response) => {
    if(response == true){
      await App.campaignfactory.newCampaign(requestIdBytes32)
      .then((result) => {
        console.log(result);
        const campaign_contract_address = result.logs[0].args.new_campaign_address;
        // const minimum_contribution = result.logs[0].args.minimum_contribution.toNumber();
        // const host_address = result.logs[0].args.host;
        // const admin_address = result.logs[0].args.admin;
        // // const minimum_contribution = donateValueId;
        
        // console.log(campaign_contract_address,minimum_contribution,host_address,admin_address);
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully create contract : '+campaign_contract_address,
          confirmButtonText: 'Close'
        })


        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestIdBytes32,
          "decide_type": "Accept",
          "newCampaignAddress": campaign_contract_address,
          "request_type" : 1
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully accept create new campaign in database');
          } else {
            console.log('UnSuccessfully accept create new campaign in database');
          }
        })
        App.renderAllRequestOpenCampaign();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
   
      
    } else {
      await App.campaignfactory.rejectCreateCampaign(requestIdBytes32)
      .then((result) => {
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Reject create contract request',
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestIdBytes32,
          "decide_type": "Decline",
          "request_type" : 1
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully decline create new campaign in database');
          } else {
            console.log('UnSuccessfully decline create new campaign in database');
          }
        })
        App.renderAllRequestOpenCampaign();
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