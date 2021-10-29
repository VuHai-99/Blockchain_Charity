pragma solidity 0.5.16;

/// @dev Stub for access control.

contract Ownable_CampaignFactory {
    
    address public owner;
    
    
    modifier onlyOwner {
        require(msg.sender == owner, "You must be owner to execute.");
        _;
    }
    
    // event LogNewOwner(address sender, address newOwner);
    
    constructor() public {
        owner = msg.sender;
    }
    
    // function changeOwner(address newOwner) public onlyOwner {
    //     require(newOwner != address(0));
    //     emit LogNewOwner(msg.sender, newOwner);
    // }
}