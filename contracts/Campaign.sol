pragma solidity 0.5.12;

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
        require(msg.sender == host, "You must be host to execute.");
        _;
    }
    modifier onlyAdmin() {
        require(msg.sender == admin ,"You must be admin to execute.");
        _;
    }
    modifier onlyHostOrAdmin() {
        require(((msg.sender == host) || (msg.sender == admin)), "You must be host or admin to execute.");
        _;
    }
    
    function contribute() public payable {
        require(msg.value > minimumContribution);
        
        // contributers.push(msg.sender);
    }
    
    function withDrawMoney(uint index) public onlyHost {
        
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
    function setMinimumContribution(uint new_minimum_contribution) public { minimumContribution = new_minimum_contribution; }

    function () external payable{
        
    }
}