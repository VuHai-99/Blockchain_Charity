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

    await App.renderCampaign(); 
  },

  renderCampaign: async () => {


    const totalCampaign = await App.campaignfactory.getDeployedCampaigns();
    const campaignTemplate = $('#recentTransactions');
    campaignTemplate.html('');
    for (let  i = totalCampaign.length; i >= 1; i--) {
        let _campaign = App.contracts.Campaign.at(totalCampaign[i-1]);

        //get minimumContribution
        let campaign_minimumContribution;
        _campaign.getMinimumContribution.call().then(function(response,index_ = i) {
          campaign_minimumContribution = response.toNumber();
          const owner_html = document.getElementById('minimumContribution_'+(index_));
          owner_html.insertAdjacentHTML('beforeend', campaign_minimumContribution +' (wei)' );
        })
        let campaign_owner;
        _campaign.getManager.call().then(function(response,index_ = i) {
          campaign_owner = String(response);
          
          const manager_html = document.getElementById('owner_'+index_);
          manager_html.insertAdjacentHTML('beforeend', campaign_owner );
        })
        let campaign_contributors;
        _campaign.getContributers.call().then(function(response,index_ = i) {
          campaign_contributors = response;
          // console.log(campaign_owner,'owner_'+(i+1)); 
          const list_contributors = campaign_contributors.join(',');
          // console.log(a);
          const donators_html = document.getElementById('donators_'+index_);
          donators_html.insertAdjacentHTML('beforeend', list_contributors );
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
                <div class="card-body">
                    <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i> SOMEDAY</strong></h4>
                    <h5 class="card-title">CAMPAIGN #${i}</h5>
                    <hr>
                    <h6 class="card-subtitle mb-2"><span class="text-muted">Campaign Address:</span> `+ totalCampaign[i-1] +`</h6>
                    <h6 class="card-subtitle mb-2" id="owner_${i}"><span class="text-muted">Campaign Owner: </span></h6>
                    <h6 class="card-subtitle mb-2" id="minimumContribution_${i}"><span class="text-muted">Campaign Minimum Contribution: </span></h6>
                    <h6 class="card-subtitle mb-2" id="balance_${i}"><span class="text-muted">Campaign Balance: </span></h6>
                    <h6 class="card-subtitle mb-2" id="donators_${i}"><span class="text-muted">Campaign Donators: </span></h6>
                </div>
            </div>
            <div class="card md-8">
              <label>Donate to Campaign</label>
              
              <form class="mb-5" onSubmit="App.donateCampaign('`+totalCampaign[i-1]+`'); return false">
                
                <div class="row">
                  <div class="col-md-8 form-group">
                    <input type="text" name="donateValueId" class="form-control" id="donateValue"
                    placeholder="EG: 100" required>
                  </div>
                  <div class="col-md-4 form-group">  
                    <button type="submit">submit</button>
                  </div>
                </div>
                      
              </form>
              
            </div>
            <div class="card md-8">
              <label>Withdraw Money Campaign</label>
              
              <form class="mb-5" onSubmit="App.withdrawMoneyCampaign('`+totalCampaign[i-1]+`'); return false">
                
                <div class="row">
                  <div class="col-md-8 form-group">
                    <input type="text" name="withdrawMoneyValueId" class="form-control" id="withdrawMoneyValue"
                    placeholder="EG: 100" required>
                  </div>
                  <div class="col-md-4 form-group">  
                    <button type="submit">submit</button>
                  </div>
                </div>
                      
              </form>
              
            </div>
        </div>`;
        // Show the task
        campaignTemplate.append(campaignItem)
    }
},

  createCampaign: async (data) => {

    let minimumContribution = $('[name="townshipId"]').val();

    await App.campaignfactory.createCampaign(Number(minimumContribution))
      .then((result) => {
        const campaign_contract_address = result.logs[0].args.newContract;
        const minimumContribution = result.logs[0].args.minimumContribution.toNumber();
        const host_address = result.logs[0].args.campaignHost;
        // const minimum_contribution = donateValueId;
        // console.log(result);
        console.log(campaign_contract_address,minimumContribution,host_address);
        Swal.fire({
          title: 'Successful!',
          text: 'Successful action',
          confirmButtonText: 'Close'
        })
        axios.post(laroute.route('create.blockchain.campaign'), {
          'campaign_contract_address': campaign_contract_address,
          'minimumContribution': minimumContribution,
          'host_address': host_address,
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully store new campaign in database');
          } else {
            console.log('UnSuccessfully store new campaign in database');
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
   
    await App.renderCampaign();
  },
  donateCampaign: async (address) => {
    // let minimumContribution = $('[name="minimumContribution"]').val();
    let donateValueId = $('[name="donateValueId"]').val();


    
    let b = App.contracts.Campaign.at(address)
    //get minimumContribution
    // b.minimumContribution.call().then(function(response) {
    //   return console.log(response.c[0]);
    // })


    b.contribute({value:donateValueId})
      .then(function(result){
        const transaction_address = result.receipt.transactionHash;
        const sender_contract_address = result.receipt.from;
        const campaign_contract_address = result.receipt.to;
        const amount_in_wei = donateValueId;
        // console.log(result)
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully contribute to the campaign',
          confirmButtonText: 'Close'
        })
        axios.post(laroute.route('store.blockchain.donation'), {
          'transaction_address': transaction_address,
          'sender_contract_address': sender_contract_address,
          'campaign_contract_address': campaign_contract_address,
          'amount_in_wei': amount_in_wei,
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully store donation transaction in database');
          } else {
            console.log('UnSuccessfully store donation transaction in database');
          }
        })


        App.renderCampaign();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',  
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
  },
  withdrawMoneyCampaign: async (address) => {
    // let minimumContribution = $('[name="minimumContribution"]').val();
    let withdrawMoneyValueId = $('[name="withdrawMoneyValueId"]').val();


    let b = App.contracts.Campaign.at(address)


    b.withDrawMoney(withdrawMoneyValueId).then(function(result){
      console.log(result)
      const transaction_address = result.receipt.transactionHash;
      const receiver_contract_address = result.receipt.to;
      const campaign_contract_address = result.receipt.from;
      const amount_in_wei = withdrawMoneyValueId;
      Swal.fire({
        title: 'Successful!',
        text: 'Successful action',
        confirmButtonText: 'Close'
      })

      axios.post(laroute.route('store.blockchain.withdraw'), {
        'transaction_address': transaction_address,
        'receiver_contract_address': receiver_contract_address,
        'campaign_contract_address': campaign_contract_address,
        'amount_in_wei': amount_in_wei,
      }).then(function(response){
        console.log(response);
        // if(response.status == 200){
        //   console.log('Successfully store withdraw transaction in database');
        // } else { 
        //   console.log('UnSuccessfully store withdraw transaction in database');
        // }
      })

      App.renderCampaign();
    }).catch(error => {
      Swal.fire({
        title: 'Unsuccessful!',
        text: error.message,
        icon: 'error',
        confirmButtonText: 'Close'
      })
    });

    // alert('Successfully Withdraw: '+withdrawMoneyValueId+' wei')
  },
}


$(window).on('load', function () {
  App.load()
});