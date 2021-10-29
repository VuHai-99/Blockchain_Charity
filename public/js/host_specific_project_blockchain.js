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

        await App.renderSpecificCampaign();
    },

    renderSpecificCampaign: async () => {
        let current_account;
        App.getAccounts(function (result) {
            current_account = result[0];
        });

        let currentUrlParams = (window.location.href).split('/');
        let projectAddress = currentUrlParams[currentUrlParams.length - 1];
        // console.log(projectAddress)

        const campaignTemplate = $('#specificProject');
        const withdrawMoneyRequest = $('#withdrawMoneyRequest');
        campaignTemplate.html('');
        let _campaign = App.contracts.Campaign.at(projectAddress);
        // console.log(_campaign)

        let campaign_host;
        _campaign.getHost.call().then(function (response) {

            campaign_host = String(response);
            if(campaign_host == current_account){
                let withdrawItem =
                `<div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-body"> 
                            <h5 class="card-title">Withdraw Money Request</h5>
                            <label>Amout of money (wei)</label>
                    
                            <form class="mb-5" onSubmit="App.createWithdrawMoneyRequest('`+projectAddress+`'); return false">
                                
                                
                                <div class="form-inline">
                                    <input class="form-control mr-1" name="withdrawAmount">
                                    <button class="btn btn-primary" type="submit">Create Request</button>
                                </div>
                                    
                            </form>
                            </h6>
                        </div>
                    </div>
                </div>`;
                withdrawMoneyRequest.append(withdrawItem)
                
            } else {
                console.log('I dont know')

            }
            const host_html = document.getElementById('host_');
            host_html.insertAdjacentHTML('beforeend', campaign_host);

        })

        let campaign_minimumContribution;
        _campaign.getMinimumContribution.call().then(function (response) {
            campaign_minimumContribution = response.toNumber();
            const owner_html = document.getElementById('minimumContribution_');
            owner_html.insertAdjacentHTML('beforeend', campaign_minimumContribution + ' (wei)');
        })

        let campaign_admin;
        _campaign.getAdmin.call().then(function (response) {

            campaign_admin = String(response);
            // console.log(campaign_admin);
            const admin_html = document.getElementById('admin_');
            admin_html.insertAdjacentHTML('beforeend', campaign_admin);
        })

        let campaign_currentBalance;
        _campaign.getBalance.call().then(function (response) {
            campaign_currentBalance = response.toNumber();
            // console.log(campaign_owner,'owner_'+(i+1)); 
            // console.log(response);
            const balance_html = document.getElementById('balance_');
            balance_html.insertAdjacentHTML('beforeend', campaign_currentBalance + '(wei)');
            // return console.log(campaign_currentBalance);
        })

        let campaignItem =
            `<div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title"><strong><i class="fa fa-calendar text-muted" aria-hidden="true"></i> SOMEDAY</strong></h4>
                        <h5 class="card-title">CAMPAIGN</h5>
                        <hr>
                        <h6 class="card-subtitle mb-2"><span class="text-muted">Campaign Address:</span> ` + projectAddress + `</h6>
                        <h6 class="card-subtitle mb-2" id="host_"><span class="text-muted">Campaign Host: </span></h6>
                        <h6 class="card-subtitle mb-2" id="admin_"><span class="text-muted">Campaign Admin: </span></h6>
                        <h6 class="card-subtitle mb-2" id="minimumContribution_"><span class="text-muted">Campaign Minimum Contribution: </span></h6>
                        <h6 class="card-subtitle mb-2" id="balance_"><span class="text-muted">Campaign Balance: </span></h6>
                        <hr>
                        <h6 class="card-subtitle mb-2">
                          <label>Donate to Campaign (wei)</label>
                
                          <form class="mb-5" onSubmit="App.donateCampaign('`+projectAddress+`'); return false">
                            
                            
                            <div class="form-inline">
                                <input class="form-control mr-1" name="donateValue">
                                <button class="btn btn-primary" type="submit">Donate</button>
                            </div>
                                  
                          </form>
                        </h6>
                    </div>
                </div>
            </div>`;
        // Show the task

        campaignTemplate.append(campaignItem)
        



        // get minimumContribution


    },

    donateCampaign: async (address) => {
      // let minimumContribution = $('[name="minimumContribution"]').val();
      let donateValue = $('[name="donateValue"]').val();
  
      console.log(donateValue);
      
      let b = App.contracts.Campaign.at(address)
      //get minimumContribution
      // b.minimumContribution.call().then(function(response) {
      //   return console.log(response.c[0]);
      // })
  
  
      b.contribute({value:donateValue})
        .then(function(result){
          const transaction_address = result.receipt.transactionHash;
          const sender_contract_address = result.receipt.from;
          const campaign_contract_address = result.receipt.to;
          const amount_in_wei = donateValue;
          console.log(result)
          Swal.fire({
            title: 'Successful!',
            text: 'Successfully contribute to the campaign',
            confirmButtonText: 'Close'
          })
          App.renderSpecificCampaign();
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
      let donateValue = $('[name="withdrawAmount"]').val();
  
    //   console.log(requestCampaignAddress);
      
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
  
          // const campaign_contract_address = result.logs[0].args.newContract;
          // const minimumContribution = result.logs[0].args.minimumContribution.toNumber();
          // const host_address = result.logs[0].args.campaignHost;
          // const minimum_contribution = donateValueId;
  
          // console.log(result);
          // console.log(result.tx);
          // console.log(campaign_contract_address,minimumContribution,host_address);
  
          Swal.fire({
            title: 'Successful!',
            text: 'Successful action',
            confirmButtonText: 'Close'
          })
          // axios.post(laroute.route('host.store.project'), {
          //   // 'name': project_name,
          //   // 'minimum_contribution': minimum_contribution,
          //   // 'date_started': date_start,
          //   // 'date_end': date_end,
          //   // 'contract_address': result.tx,
          // }).then(function(response){
          //   if(response.status == 200){
          //     console.log('Successfully store new campaign in database');
          //   } else {
          //     console.log('UnSuccessfully store new campaign in database');
          //   }
          // })
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
