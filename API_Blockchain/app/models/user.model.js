

const sql = require("./db.js");

// constructor
const User = function(user) {
  this.user_address = user.user_address;
  this.role = user.role;
  this.validate_state = user.validate_state;
  this.private_key = user.private_key;
  this.current_balance = user.current_balance;
};

User.queryFindByAddress = async (user_address, result) => {
  sql.query(`SELECT * FROM users WHERE user_address = "${user_address}"`, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);
      return err;
    }
    if (res.length) {
      // console.log("found user: ", JSON.stringify(res[0]));
      result(null, JSON.stringify(res[0]));
      return result;
    }
    result({ kind: "not_found" }, null);
  });
};

User.queryHostFindByAddress = async (user_address, result) => {
  sql.query(`SELECT * FROM users WHERE user_address = "${user_address}" AND ROLE = 1 `, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);
      return err;
    }
    if (res.length) {
      // console.log("found user: ", JSON.stringify(res[0]));
      result(null, JSON.stringify(res[0]));
      return result;
    }
    result({ kind: "not_found" }, null);
  });
};


module.exports = User;