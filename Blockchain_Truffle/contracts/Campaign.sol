pragma solidity 0.5.16;

import "./HitchensUnorderedAddressSet.sol";
contract Campaign{
    
    address payable public host;
    address public admin;
    uint public minimumContribution;
    // address[] public contributers;
    
    using HitchensUnorderedAddressSetLib for HitchensUnorderedAddressSetLib.Set;
    HitchensUnorderedAddressSetLib.Set campaignSet;

    constructor (uint minimum, address payable creator, address initial_admin) public {
        host = creator;
        minimumContribution = minimum;
        admin = initial_admin;
    }

    modifier onlyHost() {
        require(tx.origin== host, "You must be host to execute.");
        _;
    }
    modifier onlyAdmin() {
        require(tx.origin == admin ,"You must be admin to execute.");
        _;
    }
    modifier onlyHostOrAdmin() {
        require(((tx.origin == host) || (tx.origin== admin)), "You must be host or admin to execute.");
        _;
    }
    
    function contribute() public payable {
        require(msg.value > minimumContribution);
        
        // contributers.push(msg.sender);
    }
    
    function withDrawMoney(uint256 index) public onlyAdmin {
        require(index <= address(this).balance, "Cannot withdraw more than current balance.");
        address(host).transfer(index);
    }

    //getter
    function getHost() public view returns(address) { return host; }
    function getAdmin() public view returns(address) { return admin; }

    function getMinimumContribution() public view returns(uint) { return minimumContribution; }
    
    // function getContributers() public view returns(address[] memory) { return contributers; }

    function getBalance() public view returns(uint256) {return address(this).balance; }

    //setter
    function setHost(address payable new_host) public onlyAdmin { host = new_host; }
    function setMinimumContribution(uint new_minimum_contribution) public onlyAdmin { minimumContribution = new_minimum_contribution; }

    function () external payable{
        
    }
}