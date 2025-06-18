<?php
namespace App\Enums;

enum ProductTypes: string {
    case AIRTIME     = 'airtime';
    case DATA        = 'data';
    case ELECTRICITY = 'electricity';
    case TV          = 'tv';
    case EDUCATION   = 'education';
    case INSURANCE   = 'insurance';
    // Add more cases as needed
}
