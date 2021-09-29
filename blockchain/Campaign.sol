pragma solidity ^0.4.17;

contract CampaignFactory {
    
    address[] public deployedCampaigns;
        
    function createCampaign(uint minimum) public {
        address newCampaign = new Campaign(minimum,msg.sender);
        deployedCampaigns.push(newCampaign);
    }
    
    function getDeployedCampaigns() public view returns (address[]){
        return deployedCampaigns;
    }
}

contract Campaign {
    
    address public manager;
    uint public minimumContribution;
    address[] public contributers;
    
    function Campaign(uint minimum, address creator) public {
        manager = creator;
        minimumContribution = minimum;
    }
    
    modifier restricted() {
        require(msg.sender == manager);
        _;
    }
    
    function contribute() public payable {
        require(msg.value > minimumContribution);
        
        contributers.push(msg.sender);
    }
    
    function withDrawMoney(uint index) public restricted {
        
        address(manager).transfer(index);
        
    }
}