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
  },

  render: async () => {

  },

  createCampaign: async (data) => {

    let project_name = $('[name="project_name"]').val();
    let minimum_contribution = $('[name="minimum_contribution"]').val();
    let date_start = $('[name="date_start"]').val();
    let date_end = $('[name="date_end"]').val();
    // let description = $('textarea#description').val();
    // console.log(project_name, minimum_contribution, date_start, date_end);
    var currentdate = new Date(); 
    var datetime = String(currentdate.getDate() )
                    + String(currentdate.getMonth()+1)
                    + String(currentdate.getFullYear())
                    + String(currentdate.getHours() )
                    + String(currentdate.getMinutes())
                    + String(currentdate.getSeconds());
    datetime = Number(datetime)
    let newContractId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);
    console.log(newContractId)

    await App.campaignfactory.requestToOpenCamapaign(newContractId,Number(minimum_contribution))
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
  },

}


$(window).on('load', function () {
  App.load()
});