pragma solidity 0.5.16;

import "./HitchensUnorderedKeySet.sol";
import "./CampaignFactory.sol";
import "./Campaign.sol";
contract DonationActivity{
    address payable public host;
    address public authority;
    address public campaignFactory;
    modifier onlyValidatedHostCF(address _campaignFactory, address _host) {
        CampaignFactory _cf = CampaignFactory(_campaignFactory);
        if( _cf.isHostValidated(_host) == false){
            revert("You are not host.");
        }
        _;
    }

    modifier onlyAuthorityCF(address _campaignFactory, address _authority) {
        CampaignFactory _cf = CampaignFactory(_campaignFactory);
        if( _cf.isAuthority(_authority) == false){
            revert("You are not authority.");
        }
        _;
    }

    modifier originFromCampaign() {
        Campaign _c = Campaign(msg.sender);
        campaignFactory = _c.modifierFromCampaign();
        _;
    }

    modifier onlyRetailer() {
        CampaignFactory _cf = CampaignFactory(campaignFactory);
        if( _cf.isRetailer(msg.sender) == false){
            revert("You are not retailer.");
        }
        _;
    }

    modifier onlyAuthority() {
        require(authority == msg.sender, "You are not Authority !");
        _;
    }

    modifier onlyHost() {
        require(host == msg.sender, "You are not Host !");
        _;
    }

    constructor (address payable _host, address _authority, address _campaignFactory) originFromCampaign onlyValidatedHostCF(_campaignFactory,_host) onlyAuthorityCF(_campaignFactory, _authority) public {
        host = _host;
        authority = _authority;
        // campaignFactory = 0xC14FF563492d4f43EEc6218858B08fA9e0C71129;
    }

    enum OrderState{ ORDERING, DELIVERING, RECEIVED }
    struct Order {
        uint256 totalAmount;
        string receiptURI;
        address payable retailer;
        OrderState orderState;
        bool authorityConfirmation;
    }

    struct CashOut {
        uint256 amount;
        bool authorityConfirmation;
    }
    using HitchensUnorderedKeySetLib for HitchensUnorderedKeySetLib.Set;

    HitchensUnorderedKeySetLib.Set orderSet;
    mapping(bytes32 => Order) orders;
    HitchensUnorderedKeySetLib.Set cashOutSet;
    mapping(bytes32 => CashOut) cashOuts;

    
    function retailerConfirmDeliveryOrder(bytes32 _orderCode) onlyRetailer public {
        Order storage or = orders[_orderCode];
        or.orderState = OrderState.DELIVERING;
    }

    function hostConfirmReceivedOrder(bytes32 _orderCode) onlyHost public {
        Order storage or = orders[_orderCode];
        or.orderState = OrderState.RECEIVED;
        
        if(or.orderState == OrderState.RECEIVED && or.authorityConfirmation == true){
            address(or.retailer).transfer(or.totalAmount);
        }
    }

    function authorityConfirmReceivedOrder(bytes32 _orderCode) onlyAuthority public {
        Order storage or = orders[_orderCode];
        or.authorityConfirmation = true;
        
        if(or.orderState == OrderState.RECEIVED && or.authorityConfirmation == true){
            address(or.retailer).transfer(or.totalAmount);
        }
    }

    //ORDER CRUD
    function addOrder(bytes32 _orderCode, address payable _retailer, string memory _receiptURI, uint256 _totalAmount) originFromCampaign public{
        Order memory or = Order(_totalAmount,_receiptURI,_retailer, OrderState.ORDERING,false);
        orders[_orderCode] = or;
        orderSet.insert(_orderCode);
    }

    function getOrderByCode(bytes32 _orderCode) public view returns(uint256 totalAmount,string memory receiptURI,address retailer,OrderState orderState,bool authorityConfirmation){
        Order memory or = orders[_orderCode];
        return (or.totalAmount, or.receiptURI, or.retailer, or.orderState, or.authorityConfirmation);
    }

    function getOrderList() public view returns(bytes32[] memory) {
        return orderSet.listKey();
    }

    function cancelOrder(bytes32 _orderCode) public{
        orderSet.remove(_orderCode);
        delete orders[_orderCode];
    }

    function orderCodeExist(bytes32 _orderCode) public view returns(bool check){
        if(orderSet.exists(_orderCode) == false){
            return false;
        } else {
            return true;
        }
    }


    //CASHOUT CRUD
    function addCashOut(bytes32 _cashOutCode, uint256 _amount) originFromCampaign public{
        CashOut memory or = CashOut(_amount,false);
        cashOuts[_cashOutCode] = or;
        cashOutSet.insert(_cashOutCode);
    }

    function getCashOutByCode(bytes32 _cashOutCode) public view returns(uint256 amount,bool authorityConfirmation){
        CashOut memory or = cashOuts[_cashOutCode];
        return (or.amount, or.authorityConfirmation);
    }

    function getCashOutList() public view returns(bytes32[] memory) {
        return cashOutSet.listKey();
    }

    function cancelCashOut(bytes32 _cashOutCode) public{
        cashOutSet.remove(_cashOutCode);
        delete cashOuts[_cashOutCode];
    }

    function cashOutCodeExist(bytes32 _cashOutCode) public view returns(bool check){
        if(cashOutSet.exists(_cashOutCode) == false){
            return false;
        } else {
            return true;
        }
    }

    function authorityConfirmReceivedCashOut(bytes32 _cashOutCode) onlyAuthority public {
        CashOut storage or = cashOuts[_cashOutCode];
        or.authorityConfirmation = true;
        
        if(or.authorityConfirmation == true){
            address(host).transfer(or.amount);
        }
    }


    //GETTER
    function getHost() public view returns(address) { return host; }
    function getAuthority() public view returns(address) { return authority; }

    function isDonationActivityHost(address payable _host) public view returns(bool check){
        if(_host == host){
            return true;
        } else {
            return false;
        }
    }

    function () external payable{
        
    }   
}