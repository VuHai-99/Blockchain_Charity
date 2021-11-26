const mysql = require('mysql'); // or use import if you use TS
const dbConfig = require("../config/laravel_db.config");
const util = require('util');

// Create a connection to the database
const conn = mysql.createConnection({
  host: dbConfig.HOST,
  user: dbConfig.USER,
  password: dbConfig.PASSWORD,
  database: dbConfig.DB
});
// node native promisify
const query = util.promisify(conn.query).bind(conn);


const Transaction = function() {

};

Transaction.findTransaction = async (txHash) => {
  try {
    const rows = await query(`SELECT * FROM transactions WHERE transaction_hash = '${txHash}'`);
    return rows;
  } finally {
    // conn.end();
  }
}

Transaction.listAllCampaign = async () => {
  try {
    const rows = await query(`SELECT campaign_address FROM campaigns`);
    return rows;
  } finally {
    // conn.end();
  }
}

Transaction.listAllHost = async () => {
  try {
    const rows = await query(`SELECT user_address FROM users WHERE role=1;`);
    return rows;
  } finally {
    // conn.end();
  }
}

Transaction.updateTransaction = async (sender_address, receiver_address,amount, transaction_hash) => {
  try {
    const rows = await query(`UPDATE transactions SET sender_address = ?, receiver_address = ?, amount = ? WHERE transaction_hash = ?`,[sender_address, receiver_address,amount, transaction_hash]);
    return rows;
  } finally {
    // conn.end();
  }
}

Transaction.newTransaction = async (transaction_hash,sender_address, receiver_address, transaction_type,amount) => {
  try {
    const rows = await query(`INSERT INTO transactions (transaction_hash, sender_address, receiver_address, transaction_type, amount) VALUES (?, ?, ?, ? ,?);`,[transaction_hash,sender_address, receiver_address,transaction_type,amount]);
    return rows;
  } finally {
    // conn.end();
  }
}

Transaction.endMySqlConnection = async () => {
  conn.end();
}

module.exports = Transaction;