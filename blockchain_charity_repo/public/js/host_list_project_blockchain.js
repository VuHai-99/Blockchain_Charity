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

    // let accounts_ = await web3.eth.getAccounts();
    // console.log(accounts_);
  },

  render: async () => {

    await App.renderAllCampaign(); 
  },

  renderAllCampaign: async () => {


    const totalCampaign = await App.campaignfactory.getCampaignList();
    // console.log(totalCampaign);
    const campaignTemplate = $('#recentCampaigns');
    campaignTemplate.html('');
    for (let  i = totalCampaign.length; i >= 1; i--) {
        let _campaign = App.contracts.Campaign.at(totalCampaign[i-1]);
        // console.log(_campaign)
        //get minimumContribution
        let campaign_minimumContribution;
        _campaign.getMinimumContribution.call().then(function(response,index_ = i) {
          campaign_minimumContribution = response.toNumber();
          const owner_html = document.getElementById('minimumContribution_'+(index_));
          owner_html.insertAdjacentHTML('beforeend', campaign_minimumContribution +' (wei)' );
        })
        let campaign_host;
        _campaign.getHost.call().then(function(response,index_ = i) {
       
          campaign_host = String(response);
          // console.log(campaign_host);
          const host_html = document.getElementById('host_'+index_);
          host_html.insertAdjacentHTML('beforeend', campaign_host );
        })
        let campaign_admin;
        _campaign.getAdmin.call().then(function(response,index_ = i) {

          campaign_admin = String(response);
          // console.log(campaign_admin);
          const admin_html = document.getElementById('admin_'+index_);
          admin_html.insertAdjacentHTML('beforeend', campaign_admin );
        })

        let campaign_currentBalance;
        _campaign.getBalance.call().then(function(response,index_ = i) {
          campaign_currentBalance = response.toNumber();
          // console.log(campaign_owner,'owner_'+(i+1)); 
          // console.log(response);
          const balance_html = document.getElementById('balance_'+index_);
          balance_html.insertAdjacentHTML('beforeend', campaign_currentBalance+'(wei)');
          // return console.log(campaign_currentBalance);
        })
  
        let campaignItem =
            `<div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                  <h5 class="card-title">CAMPAIGN #${i}</h5>
                </div>
                <div class="card-body">
                    <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i> SOMEDAY</strong></h4>
                    <hr>
                    <h6 class="card-subtitle mb-2"><span class="text-muted">Campaign Address:</span> `+ totalCampaign[i-1] +`</h6>
                    <h6 class="card-subtitle mb-2" id="host_${i}"><span class="text-muted">Campaign Host: </span></h6>
                    <h6 class="card-subtitle mb-2" id="admin_${i}"><span class="text-muted">Campaign Admin: </span></h6>
                    <h6 class="card-subtitle mb-2" id="minimumContribution_${i}"><span class="text-muted">Campaign Minimum Contribution: </span></h6>
                    <h6 class="card-subtitle mb-2" id="balance_${i}"><span class="text-muted">Campaign Balance: </span></h6>
                </div>
                <div class="card-footer text-muted">
                  <a type="button" class="btn btn-primary" href="http://127.0.0.1:8000/charity/host/specific-project/`+ totalCampaign[i-1] +`"> Xem chi tiết. </a>
                </div>
            </div>
        </div>`;
        // Show the task
        campaignTemplate.append(campaignItem)
    }
  },

}


$(window).on('load', function () {
  App.load()
});