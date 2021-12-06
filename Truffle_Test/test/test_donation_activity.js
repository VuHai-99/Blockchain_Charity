const CampaignFactory = artifacts.require('CampaignFactory');
const Campaign = artifacts.require('Campaign');
const DonationActivity = artifacts.require('DonationActivity');

const assertError = async (promise, error) => {
  try {
    await promise;
  } catch(e) {
    assert(e.message.includes(error))
    return;
  }
  assert(false);
}

contract('CampaignFactory', accounts => {
  let campaignFactory = null;
  const [owner, authority,admin, host, retailer, donator] = accounts;
  before(async () => {
    campaignFactory = await CampaignFactory.deployed();
    // assertError(CampaignFactory.deployed());
  });

  it('Add Admin to Contract', async () => {
    console.log(campaignFactory.address);
    await campaignFactory.addAdmin(admin,{from: owner});
    // campaignFactory = await CampaignFactory.deployed();
    const test = await campaignFactory.getAdminList({from: owner});
    assert(test[0] === admin);
  });

  it('Add Authority to Contract', async () => {
    await campaignFactory.addAuthority(authority,{from: owner});
    // campaignFactory = await CampaignFactory.deployed();
    const test = await campaignFactory.isAuthority(authority,{from: owner});
    assert(test === true);
  });

  it('Add Retailer to Contract', async () => {
    await campaignFactory.addRetailer(retailer,{from: owner});
    // campaignFactory = await CampaignFactory.deployed();
    const test = await campaignFactory.isRetailer(retailer,{from: owner});
    assert(test === true);
  });

  it('Add Host to Contract', async () => {
    await campaignFactory.requestToBeValidHost({from: host});
    await campaignFactory.validateHost(host,{from: owner});
    // campaignFactory = await CampaignFactory.deployed();
    const test = await campaignFactory.isHostValidated(host,{from: owner});
    assert(test === true);
  });

  it('Open Campaign', async () => {
    await campaignFactory.requestToOpenCampaign("0x0000000000000000000000000000000000000000000000000000000000000001",101,{from: host});
    await campaignFactory.newCampaign("0x0000000000000000000000000000000000000000000000000000000000000001",{from: admin});
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    console.log('CAMPAIGN CREATED : '+campaignAddress);
    const campaign = await Campaign.at(campaignAddress);
    await campaign.contribute({from: donator,value: 10000})
    const minimumContribution = await campaign.getMinimumContribution({from: host});
    const campaign_host = await campaign.getHost({from: host});
    assert((minimumContribution.toNumber() === 101) && (campaign_host === host));
  });

  it('Open Donation Activity', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    await campaign.requestToCreateDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",host,authority,campaignFactory.address,{from: host});
    await campaign.newDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",{from: host});
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    console.log('DONATION ACTIVITY CREATED : '+donationActivityAddress);
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    const donation_host =  await donation_activity.getHost({from: host});
    const donation_authority =  await donation_activity.getAuthority({from: authority});
    assert((donation_authority === authority)&&(donation_host === host));
  });


  it('Request to create Order from Donation Activity in Campaign', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    // console.log(donationActivityAddress);
    // const donation_activity = await DonationActivity.at(donationActivityAddress);
    await campaign.requestToCreateOrderFromDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",donationActivityAddress,retailer, "Tiikii.com", 1000,{from: host})
    const requestOrderCode = await campaign.getRequestToCreateOrderFromDonationActivityList({from: host});

    assert(requestOrderCode[0] === "0x0000000000000000000000000000000000000000000000000000000000000001");

  });

  it('Accept Request to create Order from Donation Activity in Campaign', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    
    await campaign.newOrderFromDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",{from: host})
    const orderCode = await donation_activity.getOrderList({from: host});

    const donationActivityBalance = await web3.eth.getBalance(donationActivityAddress);
    assert((orderCode[0] === "0x0000000000000000000000000000000000000000000000000000000000000001")&&(donationActivityBalance === '1000'));

  });

  it('Retailer Confirm Delivering Order', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    // console.log(donationActivityAddress);
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    await donation_activity.retailerConfirmDeliveryOrder("0x0000000000000000000000000000000000000000000000000000000000000001",{from: retailer})
    const order = await donation_activity.getOrderByCode( "0x0000000000000000000000000000000000000000000000000000000000000001",{from: host});
    assert(order[3].toNumber() === 1);
  });
  
  it('Host Confirm Order Delivered', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    // console.log(donationActivityAddress);
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    await donation_activity.hostConfirmReceivedOrder("0x0000000000000000000000000000000000000000000000000000000000000001",{from: host})
    const order = await donation_activity.getOrderByCode( "0x0000000000000000000000000000000000000000000000000000000000000001",{from: host});
    assert(order[3].toNumber() === 2);
  });

  it('Authority Confirm Order Delivered', async () => {

    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    const retailer_balance_before = await web3.eth.getBalance(retailer);
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    await donation_activity.authorityConfirmReceivedOrder("0x0000000000000000000000000000000000000000000000000000000000000001",{from: authority})
    const retailer_balance_after = await web3.eth.getBalance(retailer);
    const order = await donation_activity.getOrderByCode( "0x0000000000000000000000000000000000000000000000000000000000000001",{from: host});
    assert((BigInt(retailer_balance_after)-BigInt('1000')) === BigInt(retailer_balance_before));
  });

  it('Request to create CashOut from Donation Activity in Campaign', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    // console.log(donationActivityAddress);
    // const donation_activity = await DonationActivity.at(donationActivityAddress);
    await campaign.requestToCreateCashOutFromDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",1000,donationActivityAddress,{from: host})
    const requestCashOutCode = await campaign.getRequestToCreateCashOutFromDonationActivityList({from: host});

    assert(requestCashOutCode[0] === "0x0000000000000000000000000000000000000000000000000000000000000001");

  });

  it('Accept Request to create CashOut from Donation Activity in Campaign', async () => {
    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    
    await campaign.newCashOutFromDonationActivity("0x0000000000000000000000000000000000000000000000000000000000000001",donationActivityAddress,{from: host})
    const cashOutCode = await donation_activity.getCashOutList({from: host});

    const donationActivityBalance = await web3.eth.getBalance(donationActivityAddress);
    assert((cashOutCode[0] === "0x0000000000000000000000000000000000000000000000000000000000000001")&&(donationActivityBalance === '1000'));

  });

  it('Authority Confirm CashOut Delivered', async () => {

    let campaignAddress = await campaignFactory.getCampaignList({from: owner});
    campaignAddress = campaignAddress[0]
    const campaign = await Campaign.at(campaignAddress);
    let donationActivityAddress = await campaign.getDonationActivityList({from: host});
    donationActivityAddress = donationActivityAddress[0]
    const host_balance_before = await web3.eth.getBalance(host);
    const donation_activity = await DonationActivity.at(donationActivityAddress);
    await donation_activity.authorityConfirmReceivedCashOut("0x0000000000000000000000000000000000000000000000000000000000000001",{from: authority})
    const host_balance_after = await web3.eth.getBalance(host);
    // const order = await donation_activity.getOrderByCode( "0x0000000000000000000000000000000000000000000000000000000000000001",{from: host});
    assert((BigInt(host_balance_after)-BigInt('1000')) === BigInt(host_balance_before));
  });

});

