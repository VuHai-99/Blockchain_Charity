pragma solidity 0.5.16;
/// @dev Stub for access control.

contract Ownable_CampaignFactory {
    
    address public owner;
    
    modifier onlyOwner {
        require(msg.sender == owner, "You must be owner to execute.");
        _;
    }
  
    constructor() public {
        owner = msg.sender;
    }
}