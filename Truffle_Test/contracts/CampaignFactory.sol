pragma solidity 0.5.16;

import "./HitchensUnorderedAddressSet.sol";
import "./HitchensUnorderedKeySet.sol";
import "./Ownable_CampaignFactory.sol";
import "./Campaign.sol";
contract CampaignFactory is Ownable_CampaignFactory{   

    struct RequestTobeHost {
        address requestSender;
    }
    struct RequestToOpenCampaign {
        address payable requestHost;
        uint32 minimumContribution;
    }
    using HitchensUnorderedAddressSetLib for HitchensUnorderedAddressSetLib.Set;
    using HitchensUnorderedKeySetLib for HitchensUnorderedKeySetLib.Set;

    HitchensUnorderedAddressSetLib.Set campaignSet;
    HitchensUnorderedAddressSetLib.Set validatedHostSet;
    HitchensUnorderedAddressSetLib.Set validatedAdminSet;
    HitchensUnorderedAddressSetLib.Set requestTobeHostSet;
    HitchensUnorderedAddressSetLib.Set retailerSet;
    HitchensUnorderedAddressSetLib.Set authoritySet;
    HitchensUnorderedKeySetLib.Set requestToOpenCampaignSet;

    mapping(bytes32 => RequestToOpenCampaign) requestsToOpenCampaign;

    mapping(address => RequestTobeHost) requestsTobeHost;

    mapping(address => Campaign) campaigns;
    
    event LogNewCampaign(address new_campaign_address, address admin, address host, uint minimum_contribution);
    
    function modifierFromCampaignFactory() public pure{
        
    }
    //ADMIN CRUD
    function addAdmin(address _admin) public onlyOwner{
        require(!validatedAdminSet.exists(_admin), "This account is Admin already !");
        validatedAdminSet.insert(_admin);
    }
    function removeAdmin(address _admin) public onlyOwner{
        require(validatedAdminSet.exists(_admin), "This account is not admin !");
        validatedAdminSet.remove(_admin);
    }
    function getAdminList() public view returns(address[] memory){
        return validatedAdminSet.listKey();
    }

    //Retailer CRUD
    function addRetailer(address _retailer) public onlyOwner{
        require(!retailerSet.exists(_retailer), "This account is Retailer already !");
        retailerSet.insert(_retailer);
    }
    
    function removeRetailer(address _retailer) public onlyOwner{
        require(retailerSet.exists(_retailer), "This account is not Retailer !");
        retailerSet.remove(_retailer);
    }

    function getRetailerList() public view returns(address[] memory){
        return retailerSet.listKey();
    }

    //Authority CRUD
    function addAuthority(address _authority) public onlyOwner{
        require(!authoritySet.exists(_authority), "This account is Authority already !");
        authoritySet.insert(_authority);
    }
    
    function removeAuthority(address _authority) public onlyOwner{
        require(authoritySet.exists(_authority), "This account is not Authority !");
        authoritySet.remove(_authority);
    }

    function getAuthorityList() public view returns(address[] memory){
        return authoritySet.listKey();
    }
    
    //HOST CRUD
    function validateHost(address _host) public onlyAdminAndOwner{
        require(!validatedHostSet.exists(_host), "Host is valid already!");
        require(requestTobeHostSet.exists(_host), "Host haven't request to be Host.");
        validatedHostSet.insert(_host);
        requestTobeHostSet.remove(_host);
        delete requestsTobeHost[_host];
       
    }
    
    function rejectValidateRequestHost(address _host) public onlyAdminAndOwner{
        require(requestTobeHostSet.exists(_host), "Host haven't create request to be Host.");
        requestTobeHostSet.remove(_host);
        delete requestsTobeHost[_host];
       
    }

    function removeValidatedHost(address _host) public onlyAdminAndOwner{
        require(validatedHostSet.exists(_host), "This account is not host");
        validatedHostSet.remove(_host);
    }
    
    function getValidatedHostList() public view returns(address[] memory){
        return validatedHostSet.listKey();
    }
    
    //CAMPAIGN CRUD
    function newCampaign(bytes32 requestToOpenCampaign) public onlyAdminAndOwner{
         
        // require(validatedHostSet.exists(host), "Host is not validated
        require(requestToOpenCampaignSet.exists(requestToOpenCampaign), "RequestToOpenCampaign is not valid");
        
        RequestToOpenCampaign memory re = requestsToOpenCampaign[requestToOpenCampaign];
        
        Campaign w = new Campaign(re.minimumContribution,re.requestHost,tx.origin);
    
        campaigns[address(w)] = w ;
        campaignSet.insert(address(w));
        
        requestToOpenCampaignSet.remove(requestToOpenCampaign);
        delete requestsToOpenCampaign[requestToOpenCampaign];
        emit LogNewCampaign(address(w),tx.origin,re.requestHost,re.minimumContribution);
    }
    
    function rejectCreateCampaign(bytes32 requestToOpenCampaign) public onlyAdminAndOwner{
         
        require(requestToOpenCampaignSet.exists(requestToOpenCampaign), "Invalid requestToOpenCampaign ID");
        requestToOpenCampaignSet.remove(requestToOpenCampaign);
        delete requestsToOpenCampaign[requestToOpenCampaign];

    }
    function removeCampaign(address campaign_key) public onlyAdminAndOwner{
        
        campaignSet.remove(campaign_key); 
        delete campaigns[campaign_key];

    }
    
    function getCampaign(address campaign_key) public view returns(address host, uint minimum_contribution) {
        require(campaignSet.exists(campaign_key), "Can't get a Campaign that doesn't exist.");
        Campaign w = campaigns[campaign_key];
        return(w.getHost(),w.getMinimumContribution());
    }
    
    function getCampaignList() public view returns(address[] memory){
        return campaignSet.listKey();
    }
    
    
    //REQUEST TO BE VALIDATED HOST CRUD
    function requestToBeValidHost() public {
        require(!validatedHostSet.exists(msg.sender), "Host is valid already!");
        require(!requestTobeHostSet.exists(msg.sender), "Host is in validate pending state!");
        RequestTobeHost memory re = RequestTobeHost(msg.sender);
        requestsTobeHost[msg.sender] = re;
        requestTobeHostSet.insert(msg.sender);
    }
    function getRequestToBeHostList() public onlyAdminAndOwnerAndValidatedHost view returns(address[] memory){
        return requestTobeHostSet.listKey();
    }
    function hostValidateState() public view returns(int){
        if(requestTobeHostSet.exists(msg.sender)){
            return 1;//sending
        } else {
            if(validatedHostSet.exists(msg.sender)){
                return 2;//already success
            } else {
                return 0;//havent sent
            }
        }
    }

    function cancelToBeValidHostRequest() public {
        require(requestTobeHostSet.exists(msg.sender), "You have not requested to be host.");
        requestTobeHostSet.remove(msg.sender);
        delete requestsTobeHost[msg.sender];
    }
    //REQUEST TO OPEN CAMPAIGN CRUD 
    function requestToOpenCampaign(bytes32 requestOpenCampaignCode, uint32 minimumContribution) public onlyValidatedHost{
        require(!requestToOpenCampaignSet.exists(requestOpenCampaignCode), "RequestOpenCampaignCode ID already exists.");
        RequestToOpenCampaign memory re = RequestToOpenCampaign(msg.sender,minimumContribution);
        requestsToOpenCampaign[requestOpenCampaignCode] = re;
        requestToOpenCampaignSet.insert(requestOpenCampaignCode);
    }
    function getRequestToOpenCampaignList() public onlyAdminAndOwnerAndValidatedHost view returns(bytes32[] memory){
        return requestToOpenCampaignSet.listKey();
    }

    function getRequestToOpenCampaignListAtKey(bytes32 key) public onlyAdminAndOwnerAndValidatedHost view returns(address payable _requestToOpenCampaignHost, uint32  _requestToOpenCampaignMinimumContribution) {
        RequestToOpenCampaign memory re = requestsToOpenCampaign[key];
        return (re.requestHost, re.minimumContribution);
    }
    function cancelOpenCampaignRequest(bytes32 requestToOpenCampaignCode) public onlyValidatedHost {
        require(requestToOpenCampaignSet.exists(requestToOpenCampaignCode), "Invalid requestToOpenCampaign ID");
        RequestToOpenCampaign memory re = requestsToOpenCampaign[requestToOpenCampaignCode];
       
        if(re.requestHost == msg.sender){
            requestToOpenCampaignSet.remove(requestToOpenCampaignCode);
            delete requestsToOpenCampaign[requestToOpenCampaignCode];
        } else {
            revert("You cannot cancel other hosts requests.");
        }
        
    }
    
    modifier onlyAdmin() {
        require(validatedAdminSet.exists(msg.sender), "You are not admin !");
        _;
    }
    //Modifier Helper Function
    function isHostValidated(address validatedHostAddress) public view returns(bool _result){
        if(validatedHostSet.exists(validatedHostAddress)){
            return true;
        } else {
            return false;
        }
    }
    function isRetailer(address _retailer) public view returns(bool _result){
        if(retailerSet.exists(_retailer)){
            return true;
        } else {
            return false;
        }
    }
    function isAuthority(address _authority) public view returns(bool _result){
        if(authoritySet.exists(_authority)){
            return true;
        } else {
            return false;
        }
    }
    modifier onlyAdminAndOwner() {
        if(!((validatedAdminSet.exists(msg.sender)) || (owner == msg.sender))){
            revert("You are not admin or owner");
        }
        _;
    }
    modifier onlyAdminAndOwnerAndValidatedHost() {
        if(!((validatedAdminSet.exists(msg.sender)) || (owner == msg.sender) || (validatedHostSet.exists(msg.sender)))){
            revert("You are not admin or owner");
        }
        _;
    }
    modifier onlyValidatedHost() {
        require(validatedHostSet.exists(msg.sender), "You are not a valid host !");
        _;
    }
    modifier onlyRetailer() {
        require(retailerSet.exists(msg.sender), "You are not a retailer !");
        _;
    }
}