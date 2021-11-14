const Web3 = require('web3');
const web3 = new Web3(new Web3.providers.HttpProvider('http://localhost:7545'));
const account = web3.eth.accounts.create();
console.log(account)