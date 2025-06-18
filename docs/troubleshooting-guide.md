# TheEProjects - Troubleshooting Guide

## Table of Contents

1. [Common Issues](#common-issues)
2. [Account Problems](#account-problems)
3. [Transaction Issues](#transaction-issues)
4. [Wallet Funding Problems](#wallet-funding-problems)
5. [Service-Specific Issues](#service-specific-issues)
6. [API Integration Issues](#api-integration-issues)
7. [Technical Problems](#technical-problems)
8. [Contact Support](#contact-support)

---

## Common Issues

### Site Access Problems

**Issue: Unable to access the website**
- Check your internet connection
- Try accessing the site from a different browser
- Clear your browser cache and cookies
- Check if the site is down using an online service like DownDetector
- If the problem persists, contact support

**Issue: Page loading very slowly**
- Check your internet speed
- Clear browser cache
- Try a different browser
- If using mobile data, try switching to Wi-Fi
- If the problem persists on multiple devices, contact support

**Issue: "403 Forbidden" or "404 Not Found" errors**
- Check that you're typing the URL correctly
- Clear your browser cache and cookies
- Try accessing the site using a different device or browser
- If you're trying to access a specific feature, verify that your account has permission
- Contact support if you continue to experience access issues

### Browser Compatibility

TheEProjects works best with the following browsers:
- Chrome (latest version)
- Firefox (latest version)
- Safari (latest version)
- Edge (latest version)

If you're experiencing issues with an older browser, try updating to the latest version or switching to one of the recommended browsers.

**Issue: UI elements not displaying correctly**
- Update your browser to the latest version
- Clear browser cache and cookies
- Disable browser extensions that might interfere
- Try using one of our recommended browsers
- If problems persist, contact support with screenshots of the issue

### Account Security

**Issue: Suspicious account activity**
- Change your password immediately
- Check your transaction history for unauthorized transactions
- Update your email password if you use the same email for account recovery
- Contact support immediately to report the suspicious activity
- Enable additional security features if available

---

## Account Problems

### Login Issues

**Issue: Forgotten password**
- Use the "Forgot Password?" link on the login page
- Enter your registered email address
- Check your email (including spam/junk folders) for the reset link
- Follow the link to reset your password
- If you don't receive the email within 15 minutes, request another reset link

**Issue: Account locked**
- Too many failed login attempts can temporarily lock your account
- Wait for 30 minutes and try again
- If you still can't log in, contact support with your username and registered email

**Issue: "Invalid credentials" message**
- Double-check that you're entering the correct username/email and password
- Ensure caps lock is not enabled
- Try resetting your password
- If the problem persists, contact support

### Registration Problems

**Issue: "Username already taken" error**
- Choose a different username
- Avoid common names or add numbers to make it unique

**Issue: "Email already registered" error**
- If you already have an account, use the login page instead
- If you don't have an account, ensure you're entering your email correctly
- Check if you previously registered with a different username
- Contact support if you believe someone else registered with your email

**Issue: Registration form not submitting**
- Ensure all required fields are completed
- Check that your password meets the minimum requirements (at least 6 characters)
- Ensure your password and confirm password fields match
- Try using a different browser

---

## Transaction Issues

### Failed Transactions

**Issue: "Insufficient funds" error**
- Check your wallet balance to ensure you have enough funds for the transaction
- Remember that transaction fees may apply in addition to the service amount
- Add funds to your wallet and try again
- If you believe this is an error, contact support with your account details

**Issue: Transaction shows "failed" status**
- Check your wallet balance to ensure you have sufficient funds
- Verify that the service is currently available
- Check that you entered the correct recipient information
- Wait a few minutes and check the transaction status again
- Contact support if the issue persists

**Issue: Transaction showing as "pending" for a long time**
- Most transactions are processed within minutes
- For transactions pending over 30 minutes, check the transaction details page for updates
- If no resolution after 2 hours, contact support with your transaction ID

**Issue: "Error during API request" message**
- This indicates a communication problem with our service providers
- Wait a few minutes and try again as this is often a temporary issue
- Check that all information entered is correct
- If the issue persists after several attempts, contact support

### Incorrect Transactions

**Issue: Wrong amount deducted**
- Check the service pricing and any applicable fees
- Verify the transaction details on the transaction history page
- For API users: check the difference between smart_earners_percent, topuser_earners_percent, and api_earners_percent rates
- If there's a discrepancy, contact support with your transaction ID

**Issue: Service not delivered but amount deducted**
- Wait for 15-30 minutes as some services have delayed delivery
- Check the transaction status page for updates
- For TV and Electricity services, verify the recipient information (meter number/smart card number)
- Contact support with your transaction ID and payment proof if not resolved

**Issue: Duplicate transactions**
- Check if you received multiple confirmation messages
- Verify in the transaction history if multiple transactions were processed
- Contact support immediately with the transaction IDs
- Do not attempt additional transactions until the issue is resolved

---

## Wallet Funding Problems

### Payment Gateway Issues

**Issue: Payment not reflecting in wallet**
- Automatic funding should reflect within 5 minutes of successful payment
- Check your transaction history for pending transactions
- Verify that your bank has debited your account
- For manual transfers, ensure you've submitted the payment proof
- Contact support with transaction reference if payment is debited but not reflected in wallet

**Issue: "Failed to initialize payment" error**
- Check your internet connection
- Ensure you've entered a valid amount (minimum ₦100)
- Clear your browser cache and cookies
- Try using a different payment method
- If the issue persists, contact support

**Issue: Payment gateway timeout**
- The payment processor might be experiencing high traffic or technical issues
- Try again after a few minutes
- Use a different payment method if available
- Check if your bank is having any service disruptions
- Contact support if the problem persists across multiple attempts

### Manual Funding Issues

**Issue: Manual transfer not approved**
- Verify that you've transferred the exact amount specified
- Ensure you've uploaded a clear screenshot of the payment proof
- Manual approvals typically take 1-24 hours during business days
- Check that you've included the correct transaction reference in your submission
- Contact support if your payment isn't approved after 24 hours

**Issue: Incorrect amount reflected**
- Check the transaction receipt for any fees deducted by your bank
- Verify the exact amount transferred against the amount approved
- For discrepancies, contact support with proof of payment and the expected amount

### Referral Bonuses

**Issue: Referral bonus not received**
- Ensure your referral has registered using your referral link or code
- Referral bonuses are credited after your referral makes their first transaction
- Check your wallet history for the referral credit
- Contact support if your referral has completed a transaction but you haven't received the bonus

---

## Service-Specific Issues

### Airtime Issues

**Issue: Airtime not delivered**
- Check if the transaction status shows "successful" 
- Verify that you entered the correct phone number
- Make sure the recipient's number is active and can receive airtime
- Some networks may have delays of up to 5 minutes
- If not resolved, contact support with your transaction ID

**Issue: Wrong network detected**
- Double-check the network selection before confirming the transaction
- For MTN numbers starting with certain prefixes, ensure you've selected MTN
- For ported numbers, manually select the correct current network provider
- Contact support if the system consistently detects the wrong network

**Issue: "Network unavailable" error**
- The selected network provider may be experiencing technical issues
- Wait a few minutes and try again
- Check if there are any known service outages for that network
- Try a small test transaction first

### Data Issues

**Issue: Data bundle not delivered**
- Check if the transaction status shows "successful"
- Verify that you entered the correct phone number
- Ensure you selected the correct data plan for the recipient's network
- Some data bundles may take up to 15 minutes to activate
- Check your data balance by dialing the appropriate USSD code for your network
- If not resolved, contact support with your transaction ID

**Issue: Wrong data plan delivered**
- Verify the data plan selected in your transaction details
- Check the data balance using the provider's USSD code
- For MTN users: verify if you selected from SME, Gifting, or Corporate plans
- Contact support with your transaction ID and the data plan you intended to purchase

**Issue: Data plan not showing for selection**
- Refresh the page and clear browser cache
- Make sure you've selected the correct network provider
- Some special data plans are only available to certain account types
- If you're using an API, check that you're using the correct service ID

### Electricity Issues

**Issue: Token not received**
- Check if the transaction status shows "successful"
- Verify that you entered the correct meter number
- Check your email and the transaction details page for the token
- Some electricity tokens may take up to 15 minutes to generate
- If not received after 15 minutes, contact support with your transaction ID

**Issue: Invalid meter number**
- Double-check the meter number for accuracy
- Ensure you selected the correct electricity distribution company
- Verify that your meter is currently active
- Contact your electricity provider to confirm your meter details

**Issue: "Error during meter verification API request"**
- The meter verification service might be temporarily unavailable
- Double-check that you've entered the correct meter number
- Verify that you've selected the correct distribution company (IKEDC, EKEDC, etc.)
- Confirm that the meter type (prepaid/postpaid) is correct
- Try again after a few minutes or contact support if the issue persists

### TV Subscription Issues

**Issue: Subscription not activated**
- Check if the transaction status shows "successful"
- Verify that you entered the correct smart card/IUC number
- Ensure you selected the correct TV provider and package
- Some subscriptions may take up to 15 minutes to activate
- Try refreshing your decoder by switching it off and on
- If not resolved, contact support with your transaction ID

**Issue: "Customer name verification failed"**
- Double-check your IUC/smart card number for accuracy
- Ensure the smart card is active and registered with the provider
- Verify you've selected the correct TV service provider
- The verification service might be temporarily unavailable
- Try again after a few minutes or contact support

**Issue: Cannot view available bouquets**
- Ensure you've entered a valid IUC/smart card number first
- Check that the smart card verification was successful
- Refresh the page and try again
- Use a different browser if the issue persists
- Contact support if you continue experiencing problems

### Education Payment Issues

**Issue: Registration number verification failure**
- Double-check the registration/profile ID for accuracy
- Ensure you've selected the correct exam board or institution
- Verification services may be temporarily unavailable during maintenance
- Wait a few minutes and try again
- If the issue persists, contact the institution to verify your registration details

**Issue: Result checking service unavailable**
- Check if there are any announced maintenance periods
- Verify that you've entered the correct credentials
- Some services are only available during specific periods
- Try again later or contact support for assistance

---

## API Integration Issues

### Authentication Problems

**Issue: "Invalid API key" error**
- Verify that you're using the correct API key
- Check that your API earner account is active
- Ensure the API key has not expired
- Contact support if you need to regenerate your API key

**Issue: "Unauthorized access" or "Missing authorization header"**
- Ensure you're including the API key in the header as `api-key` and secret key as `secret-key`
- Check that you're using the proper token format (e.g., "Token your_token_here")
- Verify your account has permission to access the requested endpoint
- Regenerate your API credentials if you suspect they've been compromised

### Request Failures

**Issue: API request timeouts**
- Check your internet connection
- Ensure the API endpoint URL is correct
- Try reducing the request payload size
- Implement proper error handling and retry logic
- If the issue persists, contact support

**Issue: Rate limit exceeded**
- API calls are limited to prevent abuse
- Implement caching strategies to reduce API calls
- Space out your requests over time
- Contact support if you need a higher rate limit for your use case

**Issue: "Error during API request"**
- This typically indicates a problem with the third-party service provider
- Check that all required parameters are included in your request
- Ensure parameter values are in the correct format and within valid ranges
- Implement exponential backoff retry strategy for temporary failures
- If persistent, contact support with the specific endpoint and request details

### Response Handling Errors

**Issue: Unexpected response format**
- Ensure you're properly parsing the JSON response
- Check for changes in the API response structure
- Update your code to handle variations in response formats
- Look for specific error messages in the `response_description` field

**Issue: "An unexpected error occurred"**
- This is a general error that could have various causes
- Check the complete exception message for more details
- Verify all parameters meet the required format
- Check server logs for additional context about the error
- Contact support with the specific endpoint, request payload, and error message

---

## Technical Problems

### Application Errors

**Issue: Page showing error messages**
- Clear your browser cache and cookies
- Try using incognito/private browsing mode
- Use a different browser
- If the issue persists, contact support with screenshots of the error

**Issue: "An unexpected error occurred"**
- This is a general system error that could have multiple causes
- Refresh the page and try the action again
- Clear browser cache and cookies
- Note the specific action you were trying to perform
- Contact support with details about the steps that led to the error

**Issue: Form submission errors**
- Check all required fields are properly filled
- Ensure input values meet the specified format requirements
- For payment forms, verify your card details are correct
- Try using a different browser
- If the error persists, contact support with details of the form you're trying to submit

### Performance Issues

**Issue: Slow response times**
- Check your internet connection speed
- Clear your browser cache
- Close unused browser tabs and applications
- Try accessing the platform during off-peak hours
- If the issue persists across multiple devices, contact support

**Issue: Page fails to load completely**
- Check your internet connection
- Try refreshing the page (press F5 or Ctrl+R)
- Clear browser cache and cookies
- Disable browser extensions that might interfere with page loading
- Try a different browser or device

**Issue: Images or UI elements not displaying properly**
- Clear your browser cache
- Try a different browser
- Check if you have JavaScript enabled in your browser
- Disable ad-blockers or other content-filtering extensions
- Ensure you're using a supported browser version

---

## Contact Support

If you've tried the troubleshooting steps in this guide and still need assistance, please contact our support team:

### Support Channels

**Customer Support Email:**
- support@theeprojects.com
- Please include your username and a detailed description of the issue

**Live Chat:**
- Available on the website during business hours (9 AM - 6 PM WAT, Monday to Friday)
- Best for quick questions and immediate assistance

**Phone Support:**
- Call: +234-XXX-XXX-XXXX
- Available during business hours (9 AM - 6 PM WAT, Monday to Friday)

### Information to Include

When contacting support, please provide:
1. Your username or registered email address
2. Transaction ID (if reporting a transaction issue)
3. Date and time when the issue occurred
4. Screenshots of any error messages
5. Steps you've already taken to resolve the issue
6. Any other relevant details

### Response Times

- Live Chat: Immediate to 5 minutes during business hours
- Email: Within 24 hours on business days
- Phone: Immediate to 5 minutes during business hours

For urgent issues outside business hours, please use the emergency email: urgent@theeprojects.com

---

*For urgent issues affecting multiple users or critical operations, please call our emergency support line.*

*Last updated: May 18, 2025*
