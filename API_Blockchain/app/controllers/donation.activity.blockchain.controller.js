const fs = require('fs');
const Web3 = require('web3');
const Contract = require('web3-eth-contract');
const path = require("path");
const BN = require('bn.js');

const User = require("../models/user.model.js");


const jsonFile = "../../contracts/DonationActivity.json";
const file = fs.readFileSync(path.resolve(__dirname,jsonFile));
const parsed= JSON.parse(file);
const abi = parsed.abi;

//Ganache
const web3 = new Web3(new Web3.providers.HttpProvider('http://localhost:7545'));
// creatorChain
// const web3 = new Web3(new Web3.providers.HttpProvider('https://rpc.magnet.creatorchain.network'));


exports.hostConfirmReceiveDonationActivityOrder = async (req, res) => {


  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    
    const validated_host_address = req.body.validated_host_address;
    const donation_activity_address = req.body.donation_activity_address;
    const order_code = req.body.order_code;
 
    const contract = new Contract(abi, web3.utils.toChecksumAddress(donation_activity_address));

    const encodedABI = contract.methods.hostConfirmReceivedOrder(order_code).encodeABI();



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
            `Host Attempting to Confirm Receive Donation Activity Order  from ${validated_host_address}}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: validated_host_address,
              to: donation_activity_address,
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              console.log(receipt)
              res.send("success");
            });
            
            sentTx.on("error", err => {
              console.log(err['data']['stack'])
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          console.log(err)
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

