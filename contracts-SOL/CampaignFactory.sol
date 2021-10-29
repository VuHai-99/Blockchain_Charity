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
    
    struct RequestToWithdrawMoney {
        address payable requestHost;
        address payable requestCampaign;
        uint256 amount;
    }
    
    using HitchensUnorderedAddressSetLib for HitchensUnorderedAddressSetLib.Set;
    using HitchensUnorderedKeySetLib for HitchensUnorderedKeySetLib.Set;
    
    HitchensUnorderedAddressSetLib.Set campaignSet;
    HitchensUnorderedAddressSetLib.Set validatedHostSet;
    HitchensUnorderedAddressSetLib.Set validatedAdminSet;
    HitchensUnorderedAddressSetLib.Set requestTobeHostSet;
    HitchensUnorderedKeySetLib.Set requestToOpenCampaignSet;
    HitchensUnorderedKeySetLib.Set requestToWithdrawMoneySet;
    
    
    mapping(bytes32 => RequestToOpenCampaign) requestsToOpenCampaign;
    mapping(bytes32 => RequestToWithdrawMoney) requestsToWithdrawMoney;
    mapping(address => RequestTobeHost) requestsTobeHost;
    
    
    mapping(address => Campaign) campaigns;
    
    
    
    modifier onlyAdmin() {
        require(validatedAdminSet.exists(msg.sender), "You are not admin !");
        _;
    }
    
    modifier onlyAdminAndOwner() {
        if(!((validatedAdminSet.exists(msg.sender)) || (owner == msg.sender))){
            revert("You are not admin or owner");
        }
        _;
    }
    
    modifier onlyValidatedHost() {
        require(validatedHostSet.exists(msg.sender), "You are not a valid host !");
        _;
    }
    
    event LogNewCampaign(address new_campaign_address, address admin, address host, uint minimum_contribution);
    // event LogUpdateCampaign(address current_campaign,address sender, address host, uint minimum_contribution);
    // event LogRemoveCampaign(address current_campaign,address sender);
    
    //ADMIN CRUD
    function addAdmin(address _admin) public onlyOwner{
        require(!validatedAdminSet.exists(_admin), "This account is Admin already !");
        validatedAdminSet.insert(_admin);
    }
    
    function removeAdmin(address _admin) public onlyOwner{
        require(validatedAdminSet.exists(_admin), "This account is not admin !");
        validatedAdminSet.remove(_admin);
    }
    function getAdminInAdminListAtIndex(uint index) public view returns(address _admin) {
        return validatedAdminSet.keyAtIndex(index);
    }
    function getAdminList() public view returns(address[] memory){
        return validatedAdminSet.listKey();
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
    function getHostInHostListAtIndex(uint index) public view returns(address _host) {
        return validatedHostSet.keyAtIndex(index);
    }
    function isHostValidated(address validatedHostAddress) public view returns(bool _result){
        if(validatedHostSet.exists(validatedHostAddress)){
            return true;
        } else {
            return false;
        }
    }
    function getValidatedHostList() public view returns(address[] memory){
        return validatedHostSet.listKey();
    }
    
    //CAMPAIGN CRUD
    function newCampaign(bytes32 requestToOpenCampaign) public onlyAdminAndOwner{
         // Note that this will fail automatically if the key already exists.
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
         // Note that this will fail automatically if the key already exists.
        require(requestToOpenCampaignSet.exists(requestToOpenCampaign), "Invalid requestToOpenCampaign ID");
        requestToOpenCampaignSet.remove(requestToOpenCampaign);
        delete requestsToOpenCampaign[requestToOpenCampaign];

    }
    
    function removeCampaign(address campaign_key) public onlyAdminAndOwner{
        
        campaignSet.remove(campaign_key); // Note that this will fail automatically if the key doesn't exist
        delete campaigns[campaign_key];
        // emit LogRemoveCampaign(campaign_key,msg.sender);
    }
    
    function getCampaign(address campaign_key) public view returns(address host, uint minimum_contribution) {
        require(campaignSet.exists(campaign_key), "Can't get a Campaign that doesn't exist.");
        Campaign w = campaigns[campaign_key];
        return(w.getHost(),w.getMinimumContribution());
    }
    
    function getCampaignList() public view returns(address[] memory){
        return campaignSet.listKey();
    }
    
    function getCampaignInCampaignListAtIndex(uint index) public view returns(address campaign_key) {
        return campaignSet.keyAtIndex(index);
    }
    
    //REQUEST TO BE VALIDATED HOST CRUD
    
    function requestToBeValidHost() public {
        require(!validatedHostSet.exists(msg.sender), "Host is valid already!");
        require(!requestTobeHostSet.exists(msg.sender), "Host is in validate pending state!");
        RequestTobeHost memory re = RequestTobeHost(msg.sender);
        requestsTobeHost[msg.sender] = re;
        requestTobeHostSet.insert(msg.sender);
    }
    
    function getRequestToBeHostList() public onlyAdminAndOwner view returns(address[] memory){
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
    
    function getRequestInRequestToBeHostListAtIndex(uint index) public onlyAdminAndOwner view returns(address _requestToBeHost) {
        return requestTobeHostSet.keyAtIndex(index);
    }
    
    //REQUEST TO OPEN CAMPAIGN CRUD 
    function requestToOpenCamapaign(bytes32 requestOpenCampaignCode, uint32 minimumContribution) public onlyValidatedHost{
        require(!requestToOpenCampaignSet.exists(requestOpenCampaignCode), "RequestOpenCampaignCode ID already exists.");
        RequestToOpenCampaign memory re = RequestToOpenCampaign(msg.sender,minimumContribution);
        requestsToOpenCampaign[requestOpenCampaignCode] = re;
        requestToOpenCampaignSet.insert(requestOpenCampaignCode);
    }
    
    function getRequestToOpenCampaignList() public onlyAdminAndOwner view returns(bytes32[] memory){
        return requestToOpenCampaignSet.listKey();
    }
    
    function getRequestToOpenCampaignListAtIndex(uint index) public onlyAdminAndOwner view returns(bytes32 _requestToOpenCampaign) {
        return requestToOpenCampaignSet.keyAtIndex(index);
    }
    function getRequestToOpenCampaignListAtKey(bytes32 key) public onlyAdminAndOwner view returns(address payable _requestToOpenCampaignHost, uint32  _requestToOpenCampaignMinimumContribution) {
        RequestToOpenCampaign memory re = requestsToOpenCampaign[key];
        return (re.requestHost, re.minimumContribution);
    }

    //REQUEST TO WITHDRAW MONEY CRUD
    function withDrawMoneyFunction(bytes32 requestToWithdrawMoney) public onlyAdmin {
        require(requestToWithdrawMoneySet.exists(requestToWithdrawMoney), "Invalid requestToWithdrawMoney ID");
        RequestToWithdrawMoney memory re = requestsToWithdrawMoney[requestToWithdrawMoney];
       
        Campaign a = Campaign(re.requestCampaign);
        if(re.amount > a.getBalance()){
            revert("Cannot withdraw more than current balance.");
        } else {
            a.withDrawMoney(re.amount);
            requestToWithdrawMoneySet.remove(requestToWithdrawMoney);
            delete requestsToWithdrawMoney[requestToWithdrawMoney];
        }
        
    }
    
    function rejectWithdrawMoneyRequest(bytes32 requestToWithdrawMoney) public onlyAdmin {
        require(requestToWithdrawMoneySet.exists(requestToWithdrawMoney), "Invalid requestToWithdrawMoney ID");
        requestToWithdrawMoneySet.remove(requestToWithdrawMoney);
        delete requestsToWithdrawMoney[requestToWithdrawMoney];
        
    }
    
    function requestToWithdrawMoney(bytes32 requestWithdrawMoneyCode, uint256 requestAmount, address payable requestCampaign) public onlyValidatedHost{
        require(!requestToWithdrawMoneySet.exists(requestWithdrawMoneyCode), "RequestToWithdrawMoney ID already exists.");
        
        Campaign check = Campaign(requestCampaign);
        if(check.getHost() == msg.sender){
            if(check.getBalance() >= requestAmount){
                RequestToWithdrawMoney memory re = RequestToWithdrawMoney(msg.sender,requestCampaign,requestAmount);
                requestsToWithdrawMoney[requestWithdrawMoneyCode] = re;
                requestToWithdrawMoneySet.insert(requestWithdrawMoneyCode);
            } else {
                revert("Cannot request to withdraw more than campaign balance.");
            }
            
        } else {
            revert("Only host of campaign can request for money withdraw.");
        }
        
        
    }
    
    function getRequestToWithdrawMoneyList() public onlyAdminAndOwner view returns(bytes32[] memory){
        return requestToWithdrawMoneySet.listKey();
    }
    
    function getRequestToWithdrawMoneyListAtIndex(uint index) public onlyAdminAndOwner view returns(bytes32 _requestToOpenCampaign) {
        return requestToWithdrawMoneySet.keyAtIndex(index);
    }
    
    function getRequestToWithdrawMoneyListAtKey(bytes32 key) public onlyAdminAndOwner view returns(address payable _requestToWithdrawMoneyHost,address payable _requestToWithdrawMoneyCampaign, uint256  _requestToWithdrawMoneyAmount) {
        RequestToWithdrawMoney memory re = requestsToWithdrawMoney[key];
        return (re.requestHost, re.requestCampaign, re.amount);
    }
    
}