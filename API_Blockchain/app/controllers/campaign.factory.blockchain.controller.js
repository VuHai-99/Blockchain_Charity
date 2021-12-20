const fs = require('fs');
const Web3 = require('web3');
const Contract = require('web3-eth-contract');
const path = require("path");
const BN = require('bn.js');
// const RecoverPersonalSignature  = require('eth-sig-util');
const User = require("../models/user.model.js");
const Campaign = require("../models/campaign.model.js");
const { bufferToHex } = require('ethereumjs-util');
const { recoverPersonalSignature } = require('eth-sig-util');
//Ganache
const web3 = new Web3(new Web3.providers.HttpProvider('http://localhost:7545'));
//creatorChain
// const web3 = new Web3(new Web3.providers.HttpProvider('https://rpc.magnet.creatorchain.network'));
const jsonFile = "../../contracts/CampaignFactory.json";
const file = fs.readFileSync(path.resolve(__dirname,jsonFile));
const parsed= JSON.parse(file);
//Ganache
const contract_address = parsed.networks['5777'].address;
//creatorChain
// const contract_address = parsed.networks['1509'].address;
const abi = parsed.abi;
// console.log(parsed.networks['5777'].address) // Contract Address


const contract = new Contract(abi, web3.utils.toChecksumAddress(contract_address));



exports.cancelRequestOpenCampaign = async (req, res) => {

  
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    const request_id = req.body.request_id;
    const encodedABI = contract.methods.cancelOpenCampaignRequest(request_id).encodeABI();
    const requested_to_be_host_address = req.body.host_address;
    User.queryHostFindByAddress(requested_to_be_host_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Host address is not valid."
        });
        return;
      } else {
        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        console.log(
            `Attempting to create Host Validation Request from ${requested_to_be_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: requested_to_be_host_address,
              to: contract_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send(receipt);
            });
            
            sentTx.on("error", err => {
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Host Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};


exports.requestToBeValidHost = async (req, res) => {

  const encodedABI = contract.methods.requestToBeValidHost().encodeABI();
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    
    const requested_to_be_host_address = req.body.requested_to_be_host_address;
    
    User.queryHostFindByAddress(requested_to_be_host_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Host address is not valid."
        });
        return;
      } else {
        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        console.log(
            `Attempting to create Host Validation Request from ${requested_to_be_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: requested_to_be_host_address,
              to: contract_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send(receipt);
            });
            
            sentTx.on("error", err => {
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Host Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};

exports.requestToOpenCampaign = async (req, res) => {


  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    
    const validated_host_address = req.body.validated_host_address;
    const minimum_contribution = req.body.minimum_contribution;
    const currentdate = new Date(); 
    let datetime = String(currentdate.getDate() )
                    + String(currentdate.getMonth()+1)
                    + String(currentdate.getFullYear())
                    + String(currentdate.getHours() )
                    + String(currentdate.getMinutes())
                    + String(currentdate.getSeconds());
    datetime = Number(datetime)
    let newContractId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);
    const encodedABI = contract.methods.requestToOpenCampaign(newContractId,Number(minimum_contribution)).encodeABI();

    User.queryHostFindByAddress(validated_host_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Host address is not valid."
        });
        return;
      } else {
        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        console.log(
            `Attempting to create Open Campaign Request from ${validated_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: validated_host_address,
              to: contract_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send({
                "request_id":newContractId
              });
            });
            
            sentTx.on("error", err => {
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Host Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};

exports.requestToWithdrawMoney = async (req, res) => {


  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    
    const validated_host_address = req.body.validated_host_address;
    const amount_of_money = req.body.amount_of_money;
    const campaign_adress_target = req.body.campaign_adress_target;
    const currentdate = new Date(); 
    let datetime = String(currentdate.getDate() )
                    + String(currentdate.getMonth()+1)
                    + String(currentdate.getFullYear())
                    + String(currentdate.getHours() )
                    + String(currentdate.getMinutes())
                    + String(currentdate.getSeconds());
    datetime = Number(datetime)
    let newContractId = "0x"+(new BN(String(datetime))).toTwos(256).toString('hex',64);
    const encodedABI = contract.methods.requestToWithdrawMoney(newContractId,Number(amount_of_money),campaign_adress_target).encodeABI();

    User.queryHostFindByAddress(validated_host_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Host address is not valid."
        });
        return;
      } else {
        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        console.log(
            `Attempting to create Withdraw Money Request from ${validated_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: validated_host_address,
              to: contract_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send({
                "request_id" :newContractId,
                "requested_user_address" :validated_host_address,
                "amount" :amount_of_money,
                "campaign_address" :contract_address
              });
            });
            
            sentTx.on("error", err => {
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Host Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};

exports.getHostRequestToOpenCampaignList = async (req, res) => {


  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    
    const validated_host_address = req.body.validated_host_address;

    const encodedABI = contract.methods.getRequestToOpenCampaignList().encodeABI();
    // const result = contract.methods.getRequestToOpenCampaignList().call({from:validated_host_address}).then(function(result){
    //   console.log(result)
    // })
    User.queryHostFindByAddress(validated_host_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Host address is not valid."
        });
        return;
      } else {
        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        console.log(
            `Attempting to get list of Open Campaign List from ${validated_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: validated_host_address,
              to: contract_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send(receipt);
            });
            
            sentTx.on("error", err => {
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Host Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};

exports.createNewWallet = async (req, res) => {

  try {
    const newAccount = web3.eth.accounts.create();
    res.send(newAccount)
  } catch (err) {
    res.status(500).send({
      message:
        err || "Some error occurred in transaction process."
    });
  }

};


exports.validateSignature = async (req, res) => {

  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    const publicAddress = req.body.publicAddress;
    const signData = req.body.signData;
    const CSRF = req.body.CSRF;
    const msg = `Validate Wallet Signature: ${CSRF}`;

    // We now are in possession of msg, publicAddress and signature. We
    // will use a helper from eth-sig-util to extract the address from the signature
    const msgBufferHex = bufferToHex(Buffer.from(msg, 'utf8'));
    const address = recoverPersonalSignature({
      data: msgBufferHex,
      sig: signData,
    });
    // res.send(address);
    if (address.toLowerCase() === publicAddress.toLowerCase()) {
      res.send('Success');
    } else {
      res.status(500).send({
        message:
          "Validate Wallet Signature Fail"
      });
    }
    // console.log(publicAddress,signData,CSRF)
    // res.send(address)
  }

};



