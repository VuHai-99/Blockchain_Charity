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
    App.contracts.CampaignFactory = TruffleContract(campaignfactory)
    App.contracts.CampaignFactory.setProvider(App.web3Provider)

    App.campaignfactory = await App.contracts.CampaignFactory.deployed()

    const campaign = await $.getJSON('/contracts/Campaign.json')
    App.contracts.Campaign = TruffleContract(campaign)
    App.contracts.Campaign.setProvider(App.web3Provider)

    // let accounts_ = await web3.eth.getAccounts();
    // console.log(accounts_);
  },

  checkHostValidate: async (hostCheckedAddress) => {
    let isValidated = App.campaignfactory.isHostValidated(hostCheckedAddress);
    return isValidated;
  },

  render: async () => {
    // const totalCampaign = await App.campaignfactory.isHostValidated("0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d");
    // const totalCampaign = await App.checkHostValidate("0x2821E40a6cddc5c217B1DFDceB587a81ee1d325d");
    // console.log(totalCampaign)

    let validatedList = document.querySelectorAll('.host_validation_check');
    for(let i=0; i<validatedList.length; i++){
      let hostCheckAddress = validatedList[i].id;
      // console.log(serviceGroupName);
      App.checkHostValidate(hostCheckAddress).then(function(result){
        if(result){
          validatedList[i].innerText = ("Approved");
          validatedList[i].classList.add("approved");
        } else {
          validatedList[i].innerText = ("Unapproved");
          validatedList[i].classList.add("unapprove");
        }
      })
    }
  },




}


$(window).on('load', function () {
  App.load()
});