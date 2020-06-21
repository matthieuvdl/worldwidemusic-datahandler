<?php
$countryList = array(
 'Andorra',
 'Anguilla',
 'Albania',
 'Armenia',
 'Angola',
 'Argentina',
 'Austria',
 'Australia',
 'Aruba',
 'Azerbaijan',
 'Barbados',
 'Bangladesh',
 'Belgium',
 'Bulgaria',
 'Bahrain',
 'Benin',
 'Bermuda',
 'Brunei',
 'Bolivia',
 'Brazil',
 'Bahamas',
 'Botswana',
 'Belarus',
 'Belize',
 'Canada',
 'Switzerland',
 'Chile',
 'Cameroon',
 'China',
 'Colombia',
 'Costa+Rica',
 'Cuba',
 'Curaçao',
 'Cyprus',
 'Germany',
 'Djibouti',
 'Denmark',
 'Dominica',
 'Algeria',
 'Ecuador',
 'Estonia',
 'Egypt',
 'Eritrea',
 'Spain',
 'Ethiopia',
 'Finland',
 'Faroe+Islands',
 'France',
 'Gabon',
 'Georgia',
 'Ghana',
 'Greenland',
 'Guinea',
 'Guadeloupe',
 'Greece',
 'Guatemala',
 'Guam',
 'Guyana',
 'Hong+kong',
 'Honduras',
 'Croatia',
 'Haiti',
 'Hungary',
 'Indonesia',
 'Ireland',
 'Israel',
 'India',
 'Iraq',
 'Iran',
 'Iceland',
 'Italy',
 'Jamaica',
 'Jordan',
 'Japan',
 'Kenya',
 'Cambodia',
 'North+Korea',
 'South+Korea',
 'Kuwait',
 'Kazakhstan',
 'Laos',
 'Lebanon',
 'Liechtenstein',
 'Sri+Lanka',
 'Liberia',
 'Lithuania',
 'Luxembourg',
 'Latvia',
 'Libya',
 'Morocco',
 'Monaco',
 'Montenegro',
 'Madagascar',
 'Macedonia',
 'Mali',
 'Mongolia',
 'Martinique',
 'Malta',
 'Mauritius',
 'Maldives',
 'Mexico',
 'Malaysia',
 'Mozambique',
 'Namibia',
 'Nigeria',
 'Nicaragua',
 'Netherlands',
 'Norway',
 'Nepal',
 'Nauru',
 'New+Zealand',
 'Oman',
 'Panama',
 'Peru',
 'Philippines',
 'Pakistan',
 'Poland',
 'Puerto+Rico',
 'Portugal',
 'Paraguay',
 'Qatar',
 'Reunion',
 'Romania',
 'Serbia',
 'Russia',
 'Seychelles',
 'Sudan',
 'Sweden',
 'Singapore',
 'Slovenia',
 'Slovakia',
 'Senegal',
 'Suriname',
 'Syria',
 'Chad',
 'Togo',
 'Thailand',
 'Turkmenistan',
 'Tunisia',
 'Tonga',
 'Turkey',
 'Taiwan',
 'Tanzania',
 'Ukraine',
 'Uganda',
 'UK',
 'US',
 'Uruguay',
 'Venezuela',
 'Vietnam',
 'Vanuatu',
 'Samoa',
 'Yemen',
 'Mayotte',
 'South+Africa',
 'Zambia',
 'Zimbabwe',
 'United+Arab+Emirates',
 'Uzbekistan');

$unaddedCountries = array(
'United+Arab+Emirates',
'Uzbekistan',
'Cape+Verde',
'Macau',
'Vatican+City'
);

// Old countries to merge with new countries
$countryFusion =
[
    ['Russia','USSR'],
    ['Serbia','Yugoslavia'],
    ['Czech+Republic','Czechoslovakia'],
    ['Slovakia','Czechoslovakia',]
];

$countryDatas = [];

// Decades
$decadeTable = array('1960-1969', '1970-1979', '1980-1989', '1990-1999', '2000-2009', '2010-2019', '2020');

// Music Genres
$genreTable = array('rock', 'jazz', 'pop', 'folk', 'funk', 'electronic', 'classical', 'latin', 'hiphop', 'reggae', 'blues');
