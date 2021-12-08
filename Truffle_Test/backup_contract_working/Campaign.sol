pragma solidity 0.5.16;

import "./HitchensUnorderedAddressSet.sol";
import "./HitchensUnorderedKeySet.sol";
import "./CampaignFactory.sol";
import "./DonationActivity.sol";

contract Campaign{
    
    struct RequestToCreateDonationActivity {
        address payable host;
        address authority;
        address campaignFactory;
    }

    struct RequestToCreateOrderFromDonationActivity {
        address payable donationActivity;
        address payable retailer;
        string receiptURI;
        uint256 totalAmount;
    }
    
    address payable public host;
    address public admin;
    uint public minimumContribution;
    address public campaignFactory;
    mapping(address => DonationActivity) donationActivities;
    // address[] public contributers;
    event LogNewDonationActivity(address new_campaign_address);

    using HitchensUnorderedAddressSetLib for HitchensUnorderedAddressSetLib.Set;
    using HitchensUnorderedKeySetLib for HitchensUnorderedKeySetLib.Set;
    HitchensUnorderedAddressSetLib.Set donationActivitySet;
    HitchensUnorderedKeySetLib.Set requestToCreateDonationActivitySet;
    HitchensUnorderedKeySetLib.Set requestToCreateOrderFromDonationActivitySet;
    HitchensUnorderedKeySetLib.Set requestToCreateCashOutFromDonationActivitySet;

    mapping(bytes32 => RequestToCreateDonationActivity) requestsToCreateDonationActivity;
    mapping(bytes32 => RequestToCreateOrderFromDonationActivity) requestsToCreateOrderFromDonationActivity;
    mapping(bytes32 => uint256) requestsToCreateCashOutFromDonationActivity;
    constructor (uint _minimum, address payable _host, address _initialAdmin) public originFromCampaignFactory{
        host = _host;
        minimumContribution = _minimum;
        admin = _initialAdmin;
        campaignFactory = msg.sender;
    }

    function modifierFromCampaign() public view returns(address _campaignFactory){
        return campaignFactory;
    }

    modifier originFromCampaignFactory() {
        CampaignFactory _cf = CampaignFactory(msg.sender);
        _cf.modifierFromCampaignFactory();
        _;
    }

    modifier onlyHost() {
        require(msg.sender== host, "You must be host to execute.");
        _;
    }
    modifier onlyAdmin() {
        require(msg.sender == admin ,"You must be admin to execute.");
        _;
    }
    modifier onlyHostOrAdmin() {
        require(((msg.sender == host) || (msg.sender== admin)), "You must be host or admin to execute.");
        _;
    }
    
    function contribute() public payable {
        require(msg.value > minimumContribution);
        
    }

    //getter
    function getHost() public view returns(address) { return host; }
    function getAdmin() public view returns(address) { return admin; }

    function getMinimumContribution() public view returns(uint) { return minimumContribution; }
    
    function getBalance() public view returns(uint256) {return address(this).balance; }
    function getCampaignFactory() public view returns(address) {return campaignFactory; }
    function () external payable{
        
    }
    //REQUEST TO CREATE DONATION ACTIVITY CRUD 
    function requestToCreateDonationActivity(bytes32 requestCreateDonationActivityCode,address payable _host, address _authority, address _campaignFactory) onlyHost public{
        require(!requestToCreateDonationActivitySet.exists(requestCreateDonationActivityCode), "RequestCreateDonationActivityCode ID already exists.");
        RequestToCreateDonationActivity memory re = RequestToCreateDonationActivity(_host, _authority, _campaignFactory);
        requestsToCreateDonationActivity[requestCreateDonationActivityCode] = re;
        requestToCreateDonationActivitySet.insert(requestCreateDonationActivityCode);
    }
    
    function getRequestToCreateDonationActivityList() public view returns(bytes32[] memory){
        return requestToCreateDonationActivitySet.listKey();
    }
    
    function getRequestToCreateDonationActivityListAtKey(bytes32 key) public view returns(address _host, address _authority, address _campaignFactory) {
        RequestToCreateDonationActivity memory re = requestsToCreateDonationActivity[key];
        return (re.host, re.authority,re.campaignFactory);
    }

    function cancelCreateDonationActivityRequest(bytes32 requestToCreateDonationActivityCode) onlyHostOrAdmin public {
        require(requestToCreateDonationActivitySet.exists(requestToCreateDonationActivityCode), "Invalid requestToCreateDonationActivity ID");
        requestToCreateDonationActivitySet.remove(requestToCreateDonationActivityCode);
        delete requestsToCreateDonationActivity[requestToCreateDonationActivityCode];
    }

    
    function newDonationActivity(bytes32 requestToCreateDonationActivityCode) public onlyAdmin{
         // Note that this will fail automatically if the key already exists.
        // require(validatedHostSet.exists(host), "Host is not validated.
        require(requestToCreateDonationActivitySet.exists(requestToCreateDonationActivityCode), "requestToCreateDonationActivityCode is not valid");
        
        RequestToCreateDonationActivity memory re = requestsToCreateDonationActivity[requestToCreateDonationActivityCode];
        
        DonationActivity w = new DonationActivity(re.host, re.authority,re.campaignFactory);
    
        donationActivities[address(w)] = w ;
        donationActivitySet.insert(address(w));

        
        requestToCreateDonationActivitySet.remove(requestToCreateDonationActivityCode);
        delete requestsToCreateDonationActivity[requestToCreateDonationActivityCode];
        emit LogNewDonationActivity(address(w));
    }

    function getDonationActivity(address donationActivity_key) public view returns(address _host, address _authority) {
        require(donationActivitySet.exists(donationActivity_key), "Can't get a DonationActivity that doesn't exist.");
        DonationActivity w = donationActivities[donationActivity_key];
        return (w.getHost(), w.getAuthority());
    }
    
    function getDonationActivityList() public view returns(address[] memory){
        return donationActivitySet.listKey();
    }

    //ORDER OF DONATION ACTIVITY CRUD
    modifier requestToCreateOrderFromDonationActivityCodeExist(address payable _donationActivity,bytes32 _requestToCreateOrderFromDonationActivityCode) {
        DonationActivity w = DonationActivity(_donationActivity);
        if( w.orderCodeExist(_requestToCreateOrderFromDonationActivityCode) == true){
            revert("Cannot duplicate this code");
        }
        _;
    }

    modifier checkHostDonationActivity(address payable _donationActivity) {
        DonationActivity w = DonationActivity(_donationActivity);
        if(w.isDonationActivityHost(msg.sender) == false){
            revert("You are not host of this donation activity");
        }
        _;
    }
    
    function requestToCreateOrderFromDonationActivity(bytes32 requestToCreateOrderFromDonationActivityCode,address payable _donationActivity,address payable _retailer, string memory _receiptURI, uint256 _totalAmount) onlyHost requestToCreateOrderFromDonationActivityCodeExist(_donationActivity,requestToCreateOrderFromDonationActivityCode) checkHostDonationActivity(_donationActivity) public{
        require(!requestToCreateOrderFromDonationActivitySet.exists(requestToCreateOrderFromDonationActivityCode), "requestToCreateOrderFromDonationActivityCode ID already exists.");
        RequestToCreateOrderFromDonationActivity memory re = RequestToCreateOrderFromDonationActivity(_donationActivity,_retailer, _receiptURI, _totalAmount);
        requestsToCreateOrderFromDonationActivity[requestToCreateOrderFromDonationActivityCode] = re;
        requestToCreateOrderFromDonationActivitySet.insert(requestToCreateOrderFromDonationActivityCode);
    }

    function newOrderFromDonationActivity(bytes32 requestToCreateOrderFromDonationActivityCode) public onlyAdmin{

        require(requestToCreateOrderFromDonationActivitySet.exists(requestToCreateOrderFromDonationActivityCode), "requestToCreateOrderFromDonationActivityCode is not valid");
        
        RequestToCreateOrderFromDonationActivity memory re = requestsToCreateOrderFromDonationActivity[requestToCreateOrderFromDonationActivityCode];
        
        DonationActivity w = DonationActivity(re.donationActivity);
        if(re.totalAmount > address(this).balance){
            revert("Don't Have Enough Money In Campaign");
        } else {
            w.addOrder(requestToCreateOrderFromDonationActivityCode, re.retailer, re.receiptURI, re.totalAmount);
            address(re.donationActivity).transfer(re.totalAmount);
            
            requestToCreateOrderFromDonationActivitySet.remove(requestToCreateOrderFromDonationActivityCode);
            delete requestsToCreateOrderFromDonationActivity[requestToCreateOrderFromDonationActivityCode];
        }

    }

    function cancelOrderFromDonationActivity(bytes32 requestToCreateOrderFromDonationActivityCode) public onlyHostOrAdmin{
        require(requestToCreateOrderFromDonationActivitySet.exists(requestToCreateOrderFromDonationActivityCode), "requestToCreateOrderFromDonationActivityCode is not valid");
        requestToCreateOrderFromDonationActivitySet.remove(requestToCreateOrderFromDonationActivityCode);
        delete requestsToCreateOrderFromDonationActivity[requestToCreateOrderFromDonationActivityCode];
    }

    function getRequestToCreateOrderFromDonationActivity(bytes32 requestToCreateOrderFromDonationActivityCode) public view returns(address donationActivity,address payable retailer,string memory receiptURI,uint256 totalAmount) {
        require(requestToCreateOrderFromDonationActivitySet.exists(requestToCreateOrderFromDonationActivityCode), "RequestToCreateOrderFromDonationActivityCode is not valid");
        RequestToCreateOrderFromDonationActivity memory w = requestsToCreateOrderFromDonationActivity[requestToCreateOrderFromDonationActivityCode];
        return (w.donationActivity,w.retailer,w.receiptURI,w.totalAmount);
    }
    
    function getRequestToCreateOrderFromDonationActivityList() public view returns(bytes32[] memory){
        return requestToCreateOrderFromDonationActivitySet.listKey();
    }

    //CASH OUT OF DONATION ACTIVITY CRUD
    modifier requestToCreateCashOutFromDonationActivityCodeExist(address payable _donationActivity,bytes32 _requestToCreateCashOutFromDonationActivityCode) {
        DonationActivity w = DonationActivity(_donationActivity);
        if( w.cashOutCodeExist(_requestToCreateCashOutFromDonationActivityCode) == true){
            revert("Cannot duplicate this code");
        }
        _;
    }
    
    function requestToCreateCashOutFromDonationActivity(bytes32 requestToCreateCashOutFromDonationActivityCode,uint256 _amount, address payable _donationActivity) onlyHost requestToCreateCashOutFromDonationActivityCodeExist(_donationActivity,requestToCreateCashOutFromDonationActivityCode) checkHostDonationActivity(_donationActivity) public{
        require(!requestToCreateCashOutFromDonationActivitySet.exists(requestToCreateCashOutFromDonationActivityCode), "requestToCreateCashOutFromDonationActivityCode ID already exists.");
        requestsToCreateCashOutFromDonationActivity[requestToCreateCashOutFromDonationActivityCode] = _amount;
        requestToCreateCashOutFromDonationActivitySet.insert(requestToCreateCashOutFromDonationActivityCode);
    }

    function newCashOutFromDonationActivity(bytes32 requestToCreateCashOutFromDonationActivityCode, address payable _donationActivity) public onlyAdmin{

        require(requestToCreateCashOutFromDonationActivitySet.exists(requestToCreateCashOutFromDonationActivityCode), "requestToCreateCashOutFromDonationActivityCode is not valid");
        
        uint256 amount = requestsToCreateCashOutFromDonationActivity[requestToCreateCashOutFromDonationActivityCode];
        
        DonationActivity w = DonationActivity(_donationActivity);
        if(amount > address(this).balance){
            revert("Don't Have Enough Money In Campaign");
        } else {
            w.addCashOut(requestToCreateCashOutFromDonationActivityCode, amount);
            address(_donationActivity).transfer(amount);
            
            requestToCreateCashOutFromDonationActivitySet.remove(requestToCreateCashOutFromDonationActivityCode);
            delete requestsToCreateCashOutFromDonationActivity[requestToCreateCashOutFromDonationActivityCode];
        }

    }
    function cancelCashOutFromDonationActivity(bytes32 requestToCreateCashOutFromDonationActivityCode) public onlyHostOrAdmin{
 
        require(requestToCreateCashOutFromDonationActivitySet.exists(requestToCreateCashOutFromDonationActivityCode), "requestToCreateCashOutFromDonationActivityCode is not valid");
        
        requestToCreateCashOutFromDonationActivitySet.remove(requestToCreateCashOutFromDonationActivityCode);
        delete requestsToCreateCashOutFromDonationActivity[requestToCreateCashOutFromDonationActivityCode];
    }

    function getRequestToCreateCashOutFromDonationActivity(bytes32 requestToCreateCashOutFromDonationActivityCode) public view returns(uint256 amount) {
        require(requestToCreateCashOutFromDonationActivitySet.exists(requestToCreateCashOutFromDonationActivityCode), "RequestToCreateCashOutFromDonationActivityCode is not valid");
        uint _amount = requestsToCreateCashOutFromDonationActivity[requestToCreateCashOutFromDonationActivityCode];
        return (_amount);
    }
    
    function getRequestToCreateCashOutFromDonationActivityList() public view returns(bytes32[] memory){
        return requestToCreateCashOutFromDonationActivitySet.listKey();
    }
    
}