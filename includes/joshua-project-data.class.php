<?php

/**
 * Data fetcher for Joshua Project data
 */
class T1K_JoshuaProjectData {

	/**
	* Holds the country abbreviation
	*
	* @access public
	* @since  1.0
	* @var    string
	*/
	public	$country = NULL;

	/**
	* Holds an array of all the countries with their abbreviations
	*
	* @access private
	* @since  1.0
	* @var    array
	*/
	private $country_codes = NULL;

	/**
	* Holds all the data that comes back from the remote data call
	*
	* @access private
	* @since  1.0
	* @var    object
	*/
	private $country_data = NULL;

	/**
	* The base URL for remote data calls
	*
	* @access private
	* @since  1.0
	* @var    string
	*/
	private $url = 'http://joshuaproject.net/countries-xml.php?rog3=';

	/**
	* Constructor
	*
	* @access public
	* @since  1.0
	* @return void
	*/
	public function __construct() {

		$this->country_codes = array(
			'AF' => 'Afghanistan',
			'AL' => 'Albania',
			'AG' => 'Algeria',
			'AQ' => 'American Samoa',
			'AN' => 'Andorra',
			'AO' => 'Angola',
			'AV' => 'Anguilla',
			'AC' => 'Antigua and Barbuda',
			'AR' => 'Argentina',
			'AM' => 'Armenia',
			'AA' => 'Aruba',
			'AS' => 'Australia',
			'AU' => 'Austria',
			'AJ' => 'Azerbaijan',
			'BF' => 'Bahamas',
			'BA' => 'Bahrain',
			'BG' => 'Bangladesh',
			'BB' => 'Barbados',
			'BO' => 'Belarus',
			'BE' => 'Belgium',
			'BH' => 'Belize',
			'BN' => 'Benin',
			'BD' => 'Bermuda',
			'BT' => 'Bhutan',
			'BL' => 'Bolivia',
			'BK' => 'Bosnia-Herzegovina',
			'BC' => 'Botswana',
			'BR' => 'Brazil',
			'IO' => 'British Indian Ocean Territory',
			'VI' => 'British Virgin Islands',
			'BX' => 'Brunei',
			'BU' => 'Bulgaria',
			'UV' => 'Burkina Faso',
			'BY' => 'Burundi',
			'CB' => 'Cambodia',
			'CM' => 'Cameroon',
			'CA' => 'Canada',
			'CV' => 'Cape Verde',
			'CJ' => 'Cayman Islands',
			'CT' => 'Central African Republic',
			'CD' => 'Chad',
			'CI' => 'Chile',
			'CH' => 'China',
			'HK' => 'China, Hong Kong',
			'MC' => 'China, Macau',
			'KT' => 'Christmas Island',
			'CK' => 'Cocos (Keeling) Islands',
			'CO' => 'Colombia',
			'CN' => 'Comoros',
			'CG' => 'Congo, Democratic Republic of',
			'CF' => 'Congo, Republic of the',
			'CW' => 'Cook Islands',
			'CS' => 'Costa Rica',
			'IV' => 'Cote d\'Ivoire',
			'HR' => 'Croatia',
			'CU' => 'Cuba',
			'CY' => 'Cyprus',
			'EZ' => 'Czech Republic',
			'DA' => 'Denmark',
			'DJ' => 'Djibouti',
			'DO' => 'Dominica',
			'DR' => 'Dominican Republic',
			'TT' => 'East Timor',
			'EC' => 'Ecuador',
			'EG' => 'Egypt',
			'ES' => 'El Salvador',
			'EK' => 'Equatorial Guinea',
			'ER' => 'Eritrea',
			'EN' => 'Estonia',
			'ET' => 'Ethiopia',
			'FK' => 'Falkland Islands',
			'FO' => 'Faroe Islands',
			'FJ' => 'Fiji',
			'FI' => 'Finland',
			'FR' => 'France',
			'FG' => 'French Guiana',
			'FP' => 'French Polynesia',
			'GB' => 'Gabon',
			'GA' => 'Gambia',
			'GG' => 'Georgia',
			'GM' => 'Germany',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GR' => 'Greece',
			'GL' => 'Greenland',
			'GJ' => 'Grenada',
			'GP' => 'Guadeloupe',
			'GQ' => 'Guam',
			'GT' => 'Guatemala',
			'GV' => 'Guinea',
			'PU' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HA' => 'Haiti',
			'HO' => 'Honduras',
			'HU' => 'Hungary',
			'IC' => 'Iceland',
			'IN' => 'India',
			'ID' => 'Indonesia',
			'IR' => 'Iran',
			'IZ' => 'Iraq',
			'EI' => 'Ireland',
			'IM' => 'Isle of Man',
			'IS' => 'Israel',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JA' => 'Japan',
			'JO' => 'Jordan',
			'KZ' => 'Kazakhstan',
			'KE' => 'Kenya',
			'KR' => 'Kiribati (Gilbert)',
			'KN' => 'Korea, North',
			'KS' => 'Korea, South',
			'KV' => 'Kosovo',
			'KU' => 'Kuwait',
			'KG' => 'Kyrgyzstan',
			'LA' => 'Laos',
			'LG' => 'Latvia',
			'LE' => 'Lebanon',
			'LT' => 'Lesotho',
			'LI' => 'Liberia',
			'LY' => 'Libya',
			'LS' => 'Liechtenstein',
			'LH' => 'Lithuania',
			'LU' => 'Luxembourg',
			'MK' => 'Macedonia',
			'MA' => 'Madagascar',
			'MI' => 'Malawi',
			'MY' => 'Malaysia',
			'MV' => 'Maldives',
			'ML' => 'Mali',
			'MT' => 'Malta',
			'RM' => 'Marshall Islands',
			'MB' => 'Martinique',
			'MR' => 'Mauritania',
			'MP' => 'Mauritius',
			'MF' => 'Mayotte',
			'MX' => 'Mexico',
			'FM' => 'Micronesia, Federated States',
			'MD' => 'Moldova',
			'MN' => 'Monaco',
			'MG' => 'Mongolia',
			'MJ' => 'Montenegro',
			'MH' => 'Montserrat',
			'MO' => 'Morocco',
			'MZ' => 'Mozambique',
			'BM' => 'Myanmar (Burma)',
			'WA' => 'Namibia',
			'NR' => 'Nauru',
			'NP' => 'Nepal',
			'NL' => 'Netherlands',
			'NT' => 'Netherlands Antilles',
			'NC' => 'New Caledonia',
			'NZ' => 'New Zealand',
			'NU' => 'Nicaragua',
			'NG' => 'Niger',
			'NI' => 'Nigeria',
			'NE' => 'Niue',
			'NF' => 'Norfolk Island',
			'CQ' => 'Northern Mariana Islands',
			'NO' => 'Norway',
			'MU' => 'Oman',
			'PK' => 'Pakistan',
			'PS' => 'Palau',
			'WE' => 'Palestine (West Bank / Gaza)',
			'PM' => 'Panama',
			'PP' => 'Papua New Guinea',
			'PA' => 'Paraguay',
			'PE' => 'Peru',
			'RP' => 'Philippines',
			'PC' => 'Pitcairn Islands',
			'PL' => 'Poland',
			'PO' => 'Portugal',
			'RQ' => 'Puerto Rico',
			'QA' => 'Qatar',
			'RE' => 'Reunion',
			'RO' => 'Romania',
			'RS' => 'Russia',
			'RW' => 'Rwanda',
			'SH' => 'Saint Helena',
			'SC' => 'Saint Kitts and Nevis',
			'ST' => 'Saint Lucia',
			'SB' => 'Saint Pierre and Miquelon',
			'WS' => 'Samoa',
			'SM' => 'San Marino',
			'TP' => 'Sao Tome and Principe',
			'SA' => 'Saudi Arabia',
			'SG' => 'Senegal',
			'RI' => 'Serbia',
			'SE' => 'Seychelles',
			'SL' => 'Sierra Leone',
			'SN' => 'Singapore',
			'LO' => 'Slovakia',
			'SI' => 'Slovenia',
			'BP' => 'Solomon Islands',
			'SO' => 'Somalia',
			'SF' => 'South Africa',
			'SP' => 'Spain',
			'CE' => 'Sri Lanka',
			'VC' => 'St Vincent and Grenadines',
			'SU' => 'Sudan',
			'NS' => 'Suriname',
			'SV' => 'Svalbard',
			'WZ' => 'Swaziland',
			'SW' => 'Sweden',
			'SZ' => 'Switzerland',
			'SY' => 'Syria',
			'TW' => 'Taiwan',
			'TI' => 'Tajikistan',
			'TZ' => 'Tanzania',
			'TH' => 'Thailand',
			'TO' => 'Togo',
			'TL' => 'Tokelau',
			'TN' => 'Tonga',
			'TD' => 'Trinidad and Tobago',
			'TS' => 'Tunisia',
			'TU' => 'Turkey',
			'TX' => 'Turkmenistan',
			'TK' => 'Turks and Caicos Islands',
			'TV' => 'Tuvalu',
			'UG' => 'Uganda',
			'UP' => 'Ukraine',
			'AE' => 'United Arab Emirates',
			'UK' => 'United Kingdom',
			'US' => 'United States',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'NH' => 'Vanuatu',
			'VT' => 'Vatican City',
			'VE' => 'Venezuela',
			'VM' => 'Vietnam',
			'VQ' => 'Virgin Islands (U.S.)',
			'WF' => 'Wallis and Futuna Islands',
			'WI' => 'Western Sahara',
			'YM' => 'Yemen',
			'ZA' => 'Zambia',
			'ZI' => 'Zimbabwe',
		);
	}

	/**
	 * Returns country code var
	 *
	 * @access public
	 * @return array
	 */
	public function get_country_codes() {
		return $this->country_codes;
	}

	/**
	 * Sets the country code for this object
	 *
	 * @access public
	 * @return void
	 */
	public function set_country( $country ) {
		if ( array_key_exists( $country,$this->country_codes ) ) {
			$this->country = $country;
		} else {
			$this->country = NULL;
		}
	}

	/**
	 * Fetches country data from Joshua Project or from the transient cache
	 *
	 * @access public
	 * @return object
	 */
	public function get_data() {

		if ( $this->country != NULL ) {

			$transient_name = 'jp_data_' . esc_attr( $this->country );

			$remote_country_data = get_transient( $transient_name );

			if ( $remote_country_data == '' ) {

				$get_data  = wp_remote_get( esc_url( $this->url . $this->country ) );
				$remote_country_data = $get_data['body'];

				set_transient( $transient_name, $remote_country_data, 60 * 60 * 12 );

			}

			$this->country_data = simplexml_load_string( $remote_country_data );

			return $this->country_data;

		}

	}

	// end class
}
