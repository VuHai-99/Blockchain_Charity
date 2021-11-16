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

    await App.renderAllRequestWithdrawMoney(); 
  },

  renderAllRequestWithdrawMoney: async () => {


    const totalRequestWithdrawMoney = await App.campaignfactory.getRequestToWithdrawMoneyList();
    // console.log(totalRequestWithdrawMoney);
    const campaignTemplate = $('#recentRequestWithdrawMoney');
    campaignTemplate.html('');

    for (let  i = 0; i < totalRequestWithdrawMoney.length; i++) {
      let temp = await App.campaignfactory.getRequestToWithdrawMoneyListAtKey(totalRequestWithdrawMoney[i]);
      
      // console.log(temp[0]);
      // console.log(temp[1]);
      // console.log(temp[2].toNumber());

      let campaignItem =
          `<div class="col-md-12">
            <form>
              <div class="card mt-4">
                  <div class="card-header">
                    <h5 class="card-title">REQUEST WITHDRAW MONEY #${i + 1}</h5>
                  </div>
                  <div class="card-body">
                    <h6 class="card-subtitle mb-2"><span class="text-muted">Campaign Address:</span> `+ temp[1] +`</h6>
                      <h6 class="card-subtitle mb-2"><span class="text-muted">Requested Host:</span> `+ temp[0] +`</h6>
                      <h6 class="card-subtitle mb-2"><span class="text-muted">Amount of money:</span> `+ temp[2].toNumber()+`</h6>
                  </div>
                  <div class="card-footer">
                    <a type="button" class="btn btn-success text-light" onclick="App.responseRequestWithdrawMoney('`+totalRequestWithdrawMoney[i]+`',true,`+ temp[2]+`); return false"> Đồng ý </a>
                    <a type="button" class="btn btn-danger text-light" onclick="App.responseRequestWithdrawMoney('`+totalRequestWithdrawMoney[i]+`',false,`+ temp[2]+`); return false"> Từ chối </a>
                  </div>
              </div>
            </form>
          </div>`;
      // Show the task
      campaignTemplate.append(campaignItem)
    }
  },
  responseRequestWithdrawMoney: async (requestedWithdrawMoneyID, response,withdrawValue) => {
    if(response == true){
      await App.campaignfactory.withDrawMoneyFunction(requestedWithdrawMoneyID)
      .then((result) => {
        // console.log(result);
        const host_contract_address = result.receipt.from;
        const campaign_contract_address = result.receipt.to;
        const transaction_hash = result.receipt.transactionHash;
        const amount_in_wei = withdrawValue;
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully allow money withdrawal ',
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestedWithdrawMoneyID,
          "decide_type": "Accept"
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully accept withdraw money campaign in database');
          } else {
            console.log('UnSuccessfully accept withdraw money campaign in database');
          }
        })
        axios.post(('/api/store-transaction'), {
          "transaction_hash": transaction_hash,
          "sender_address": campaign_contract_address,
          "receiver_address": host_contract_address,
          "transaction_type" : 1,
          "amount":amount_in_wei
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully store donation info in database');
          } else {
            console.log('UnSuccessfully store donation info in database');
          }
        })
        App.renderAllRequestWithdrawMoney();
      }).catch(error => {
        Swal.fire({
          title: 'Unsuccessful!',
          text: error.message,
          icon: 'error',
          confirmButtonText: 'Close'
        })
      });
   
      
    } else {
      await App.campaignfactory.rejectWithdrawMoneyRequest(requestedWithdrawMoneyID)
      .then((result) => {
        Swal.fire({
          title: 'Successful!',
          text: 'Successfully Reject money withdrawal',
          confirmButtonText: 'Close'
        })
        axios.post(('/api/decide-blockchain-request'), {
          "request_id": requestedWithdrawMoneyID,
          "decide_type": "Decline"
        }).then(function(response){
          if(response.status == 200){
            console.log('Successfully reject withdraw money campaign in database');
          } else {
            console.log('UnSuccessfully reject withdraw money campaign in database');
          }
        })
        App.renderAllRequestWithdrawMoney();
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