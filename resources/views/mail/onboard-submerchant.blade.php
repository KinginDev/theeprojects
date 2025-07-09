@component('mail::message')
# Welcome to {{ $merchant->name }}

Hello {{ $subMerchant->name }},

You have been added as a sub-merchant on the {{ $merchant->name }} platform.

@component('mail::panel')
    ## Your Merchant Details
    **Merchant Name**: {{ $subMerchant->name }}
    **Email**: {{ $subMerchant->email }}
    **Domain**: {{ $subMerchant->domain }}
@endcomponent

To complete your onboarding, please click the button below to set up your account:

@component('mail::button', ['url' => route('merchant.submerchant.onboard.page', ['token' => $subMerchant->token])])
    Complete Onboarding
@endcomponent

After logging in, you'll be able to:
- Set up your merchant profile
- Configure your payment settings
- Add users to your account
- Access all your merchant features

If you have any questions or need assistance, please contact us.

Thank you,<br>
{{ $merchant->name }} Team
@endcomponent
