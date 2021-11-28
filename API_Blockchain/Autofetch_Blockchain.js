#!/usr/bin/env node
const Transaction = require("./app/models/transaction.model");
const ethers = require('ethers');
const moment = require('moment');
const abiDecoder = require('abi-decoder');
// const moment = require('moment');

let rpcProvider;

setupProvider();
// onData(920);
rpcProvider.on('block', onPreviousLatestData);
// syncBlockRange(919,922);
// console.log(rpcProvider);

async function setupProvider() {
    var provider = ethers.providers.JsonRpcProvider;
    rpcProvider = new provider('http://127.0.0.1:7545');    
}

async function onPreviousLatestData(blockNumber, error) {
    if (error && error.reason) {
        return console.log(`Error while receiving data: ${error.reason}`);
    }
    rpcProvider.getBlockWithTransactions(blockNumber-1).then(syncBlock);
    // let a = await rpcProvider.getBlockWithTransactions(blockNumber);
    // console.log(a);
    console.log('SYNCING BLOCK '+(blockNumber-1).toString())
}

function syncBlock(block) {
    // const promises = [];
    if (block) {
        for (var i = 0; i < block.transactions.length; i++) {
            const transaction = block.transactions[i]
            syncTransaction(transaction)
            // console.log(transaction)

        }
    }
}

async function syncBlockRange(from,to) {

    if (from >= to) {
        console.log('"to" must be greater than "from".');
        process.exit(1);
    }
    const promises = [];
    for (var i = from; i <= to; i++)
        await rpcProvider.getBlockWithTransactions(i).then(syncBlock)

    await process.exit(0)
}

function syncTransaction(transaction) {
    let hash = transaction['hash'];
    let from = transaction['from'];
    let to = transaction['to'];
    let amount = transaction['value'];
    let data = transaction['data'];
    let campaignFactoryAddress = '0xad0c66f9a9E088cdb7A7D6FECeB7CC7Eab3b2f26'
    if(from == campaignFactoryAddress || to == campaignFactoryAddress){ //This is all transaction related to contract campaign factory
        // console.log('transaction related to contract campaign');
        // console.log(data)
        // console.log(abiDecoder.decodeLogs(data))
    } else {
        Transaction.listAllCampaign().then((res) => {
            const listAllCampaign = [];
            for (const cam of res) {
                // console.log(cam['campaign_address'])
                listAllCampaign.push(cam['campaign_address'])
            }
            Transaction.findTransaction(hash).then((res) => {
    
                // if it can find the transaction in DB
                if(res.length == 1)
                {
                    // this is donation to campaign request
                    if(listAllCampaign.includes(to.toLowerCase())){
                        // Check if db is store correct info ,if not change it .
                        if((res[0]['receiver_address'] != to.toLowerCase()) || 
                            (res[0]['amount'] != amount.toNumber().toString()) || 
                            (res[0]['sender_address'] != from.toLowerCase())){
                            Transaction.updateTransaction(from.toLowerCase(),to.toLowerCase(),amount.toNumber().toString(),hash).then((res) =>{
                                console.log('Successful Sync Transaction: '+hash);
                            });
                            
                        } 
                        // console.log(typeof res[0]['amount']);
                    }
                } 
                // if it can NOT find the transaction in DB
                else if(res.length == 0)
                {
                    //if "to" field is the campaign. Add new donation transaction to the db
                    if(listAllCampaign.includes(to.toLowerCase())){
                        Transaction.newTransaction(hash,from.toLowerCase(),to.toLowerCase(),0,amount.toNumber().toString()).then((res) =>{
                            console.log('Successful Sync New Transaction: '+hash);
                        });
                        // console.log('GGCAUSE')
                    }
                    // console.log(abiDecoder.decodeMethod(res[0]['data']));
                }
            });
        });
    }
   
}