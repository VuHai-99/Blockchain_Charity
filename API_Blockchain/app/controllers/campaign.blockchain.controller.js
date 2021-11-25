const fs = require('fs');
const Web3 = require('web3');
const Contract = require('web3-eth-contract');
const path = require("path");


const User = require("../models/user.model.js");

const web3 = new Web3(new Web3.providers.HttpProvider('http://localhost:7545'));
const jsonFile = "../../contracts/Campaign.json";
const file = fs.readFileSync(path.resolve(__dirname,jsonFile));
const parsed= JSON.parse(file);
const abi = parsed.abi;

// const contract = new Contract(abi, web3.utils.toChecksumAddress("0xAD93472777a78F8D654Cb3e85dcc36defd259Cb5"));
// const encodedABI = contract.methods.contribute().encodeABI();

exports.donateToCampaign = async (req, res) => {
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
    return;
  } else if(!req.params.campaign_address){
    res.status(400).send({
      message: "campaign_address can not be empty!"
    });
    return;
  } else {
    // Create a Campaign
    // try {
    //   const contract = new Contract(abi, web3.utils.toChecksumAddress(req.params.campaign_address));
    //   const encodedABI = contract.methods.contribute().encodeABI();
    // } catch (err) {
    //   res.status(500).send({
    //     message:
    //       err.message || "Your campaign address is invalid"
    //   });
    //   return;
    // }
    
    const contract = new Contract(abi, web3.utils.toChecksumAddress(req.params.campaign_address));
    const encodedABI = contract.methods.contribute().encodeABI();
    
    const campaign_address = req.params.campaign_address

    //Body of request
    const donator_address = req.body.donator_address
    const amoutOfEthereum = req.body.amoutOfEthereum

     
    
    try {
      let amoutOfDonationInEthereum =  web3.utils.toWei(amoutOfEthereum.toString(), 'ether')
    } catch (err) {
      res.status(500).send({
        message:
          err.message || "Your amount of ether is not valid."
      });
      return;
    }
    

    User.queryFindByAddress(donator_address, (err, current_user) => {
      if (err) {
        res.status(500).send({
          message:
            err.message || "Donator address is not valid."
        });
        return;
      } else {
        // console.log(current_user)


        currentUserJson = JSON.parse(current_user)
        privKey = currentUserJson.private_key
        // console.log(current_user)
        console.log(
            `Attempting to make donation from ${donator_address} to Campaign ${campaign_address}`
        );

        // console.log(req.body.amoutOfEthereum)

        const createTransaction = web3.eth.accounts.signTransaction(
          {
              from: donator_address,
              to: campaign_address,
              // value: web3.utils.toWei(amoutOfEthereum.toString(), 'ether'),
              value: amoutOfEthereum.toString(),
              gas: 2000000,
              data: encodedABI,
          },
          privKey
        );
        createTransaction.then((signedTx) => {  

            // raw transaction string may be available in .raw or 
            // .rawTransaction depending on which signTransaction
            // function was called
            const sentTx = web3.eth.sendSignedTransaction(signedTx.raw || signedTx.rawTransaction);  
            
            sentTx.on("receipt", receipt => {
              // console.log(receipt)
              // const donation = new Donation({
              //   donation_transaction_hash : receipt.transactionHash ,
              //   donator_address: receipt.from,
              //   campaign_address: receipt.to,
              //   donation_amount: amoutOfEthereum,
              // });
              res.send(receipt);
            });
            
            sentTx.on("error", err => {
              // console.log(Object.keys(err['data']['stack']))
              // console.log(err['data']['stack'])
              res.status(500).send({
                message:
                  err['data']['stack'] || "Some error occurred in transaction process."
              });
            });
            
        }).catch((err) => {
          res.status(500).send({
            message:
              err.message || "Invalid Donator Address."
          });
          // console.log(err)
          
        });
      }
    });
    
  
  }

  
};