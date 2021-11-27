App = {
    contracts: {},
    load: async () => {
      
      await App.loadWeb3()
      // await App.handleClick()
      
    },
  
    loadWeb3: async () => {
    //   const Web3 = require('web3');
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
    handleAuthenticate : (publicAddress,signature) =>
    {
      console.log(signature);
    }
    ,
    handleSignMessage : async (publicAddress, nonce) => {
      try {
        const signature = await web3.eth.personal.sign(
          `Validate Wallet Signature: ${nonce}`,
          publicAddress,
          '' // MetaMask will ignore the password argument here
        );
  
        return { publicAddress, signature };
      } catch (err) {
        throw new Error(
          'You need to sign the message to be able to log in.'
        );
      }
    },
    handleClick : async () => {
    await App.loadWeb3()
        // console.log(await web3.eth.getCoinbase());

		const coinbase = await web3.eth.getCoinbase();

		if (!coinbase) {
			window.alert('Please activate MetaMask first.');
			return;
		} else {
      // console.log(coinbase)
      const publicAddress = coinbase.toLowerCase();
      const cookies = (document.cookie).split(";");
      // res = await App.handleSignMessage(publicAddress,"101010")
      // console.log(res['signature'])
      let signData;
      let CSRF;
      for (cookie of cookies) {
        if(cookie.includes("XSRF-TOKEN")){
          
          // signData = decodeURIComponent(cookie.split("XSRF-TOKEN=")[1])
          CSRF = decodeURIComponent(cookie.split("XSRF-TOKEN=")[1])
          signData = await App.handleSignMessage(publicAddress,CSRF)
          signData = signData['signature']
        }
      }

      // console.log(signData)
      document.getElementById('signData').value = signData;
      document.getElementById('CSRF').value = CSRF;
      document.getElementById('wallet_address').value = publicAddress;
      document.getElementById("validate_metamask_button").classList.add('btn-success');
      document.getElementById("validate_metamask_button").classList.remove('btn-danger');
      document.getElementById("validate_metamask_button").innerHTML = "SIGNED";

      // axios.post(('/metamask_kyc/signed'), {
      //   "publicAddress": publicAddress,
      //   "signData": signData,
      //   "CSRF": CSRF,
      // }).then(function(response){
      //   if(response.status == 200){
      //     console.log(response);
      //     document.getElementById('signData').value = signData;
      //     document.getElementById('CSRF').value = CSRF;
      //   } else {
      //     console.log('UnSuccessfully store new validated request in database');
      //   }
      // })
      
    }

		// const publicAddress = coinbase.toLowerCase();
		// console.log(publicAddress)
	}
}

$(window).on('load', function () {
  // App.load()
});