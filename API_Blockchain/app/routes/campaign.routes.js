module.exports = app => {
    const campaign = require("../controllers/campaign.controller.js");
    const testCalFunc = require("../../test_callFunc.js");
    // Create a new Customer
    app.post("/campaigns", campaign.create);
  
    // // Retrieve all Customers
    // app.get("/campaigns", customers.findAll);
  
    // // Retrieve a single Customer with customerId
    // app.get("/customers/:customerId", customers.findOne);
  
    // // Update a Customer with customerId
    // app.put("/customers/:customerId", customers.update);
  
    // // Delete a Customer with customerId
    // app.delete("/customers/:customerId", customers.delete);
  
    // // Create a new Customer
    // app.delete("/customers", customers.deleteAll);
  };