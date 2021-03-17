export default {
    en: {
        auth: {
            failed: "These credentials do not match our records.",
            throttle:
                "Too many login attempts. Please try again in {seconds} seconds."
        },
        pagination: {
            previous: "&laquo; Previous",
            next: "Next &raquo;"
        },
        passwords: {
            reset: "Your password has been reset!",
            sent: "We have emailed your password reset link!",
            throttled: "Please wait before retrying.",
            token: "This password reset token is invalid.",
            user: "We can't find a user with that email address."
        },
        validation: {
            accepted: "The {attribute} must be accepted.",
            active_url: "The {attribute} is not a valid URL.",
            after: "The {attribute} must be a date after {date}.",
            after_or_equal:
                "The {attribute} must be a date after or equal to {date}.",
            alpha: "The {attribute} may only contain letters.",
            alpha_dash:
                "The {attribute} may only contain letters, numbers, dashes and underscores.",
            alpha_num: "The {attribute} may only contain letters and numbers.",
            array: "The {attribute} must be an array.",
            before: "The {attribute} must be a date before {date}.",
            before_or_equal:
                "The {attribute} must be a date before or equal to {date}.",
            between: {
                numeric: "The {attribute} must be between {min} and {max}.",
                file:
                    "The {attribute} must be between {min} and {max} kilobytes.",
                string:
                    "The {attribute} must be between {min} and {max} characters.",
                array:
                    "The {attribute} must have between {min} and {max} items."
            },
            boolean: "The {attribute} field must be true or false.",
            confirmed: "The {attribute} confirmation does not match.",
            date: "The {attribute} is not a valid date.",
            date_equals: "The {attribute} must be a date equal to {date}.",
            date_format: "The {attribute} does not match the format {format}.",
            different: "The {attribute} and {other} must be different.",
            digits: "The {attribute} must be {digits} digits.",
            digits_between:
                "The {attribute} must be between {min} and {max} digits.",
            dimensions: "The {attribute} has invalid image dimensions.",
            distinct: "The {attribute} field has a duplicate value.",
            email: "The {attribute} must be a valid email address.",
            ends_with:
                "The {attribute} must end with one of the following: {values}.",
            exists: "The selected {attribute} is invalid.",
            file: "The {attribute} must be a file.",
            filled: "The {attribute} field must have a value.",
            gt: {
                numeric: "The {attribute} must be greater than {value}.",
                file: "The {attribute} must be greater than {value} kilobytes.",
                string:
                    "The {attribute} must be greater than {value} characters.",
                array: "The {attribute} must have more than {value} items."
            },
            gte: {
                numeric:
                    "The {attribute} must be greater than or equal {value}.",
                file:
                    "The {attribute} must be greater than or equal {value} kilobytes.",
                string:
                    "The {attribute} must be greater than or equal {value} characters.",
                array: "The {attribute} must have {value} items or more."
            },
            image: "The {attribute} must be an image.",
            in: "The selected {attribute} is invalid.",
            in_array: "The {attribute} field does not exist in {other}.",
            integer: "The {attribute} must be an integer.",
            ip: "The {attribute} must be a valid IP address.",
            ipv4: "The {attribute} must be a valid IPv4 address.",
            ipv6: "The {attribute} must be a valid IPv6 address.",
            json: "The {attribute} must be a valid JSON string.",
            lt: {
                numeric: "The {attribute} must be less than {value}.",
                file: "The {attribute} must be less than {value} kilobytes.",
                string: "The {attribute} must be less than {value} characters.",
                array: "The {attribute} must have less than {value} items."
            },
            lte: {
                numeric: "The {attribute} must be less than or equal {value}.",
                file:
                    "The {attribute} must be less than or equal {value} kilobytes.",
                string:
                    "The {attribute} must be less than or equal {value} characters.",
                array: "The {attribute} must not have more than {value} items."
            },
            max: {
                numeric: "The {attribute} may not be greater than {max}.",
                file:
                    "The {attribute} may not be greater than {max} kilobytes.",
                string:
                    "The {attribute} may not be greater than {max} characters.",
                array: "The {attribute} may not have more than {max} items."
            },
            mimes: "The {attribute} must be a file of type: {values}.",
            mimetypes: "The {attribute} must be a file of type: {values}.",
            min: {
                numeric: "The {attribute} must be at least {min}.",
                file: "The {attribute} must be at least {min} kilobytes.",
                string: "The {attribute} must be at least {min} characters.",
                array: "The {attribute} must have at least {min} items."
            },
            not_in: "The selected {attribute} is invalid.",
            not_regex: "The {attribute} format is invalid.",
            numeric: "The {attribute} must be a number.",
            password: "The password is incorrect.",
            present: "The {attribute} field must be present.",
            regex: "The {attribute} format is invalid.",
            required: "The {attribute} field is required.",
            required_if:
                "The {attribute} field is required when {other} is {value}.",
            required_unless:
                "The {attribute} field is required unless {other} is in {values}.",
            required_with:
                "The {attribute} field is required when {values} is present.",
            required_with_all:
                "The {attribute} field is required when {values} are present.",
            required_without:
                "The {attribute} field is required when {values} is not present.",
            required_without_all:
                "The {attribute} field is required when none of {values} are present.",
            same: "The {attribute} and {other} must match.",
            size: {
                numeric: "The {attribute} must be {size}.",
                file: "The {attribute} must be {size} kilobytes.",
                string: "The {attribute} must be {size} characters.",
                array: "The {attribute} must contain {size} items."
            },
            starts_with:
                "The {attribute} must start with one of the following: {values}.",
            string: "The {attribute} must be a string.",
            timezone: "The {attribute} must be a valid zone.",
            unique: "The {attribute} has already been taken.",
            uploaded: "The {attribute} failed to upload.",
            url: "The {attribute} format is invalid.",
            uuid: "The {attribute} must be a valid UUID.",
            custom: {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            attributes: []
        },
        words: {
            general: {
                latestProducts: "Latest Products",
                quickView: "Quick View",
                rs: "Rs",
                topSellingProducts: "Top Selling Products",
                productOffers: "Product With Offers",

                topSeller: "Top Sellers",
                topBrand: "Top Brands",
                productCollect: "Product Collections",
                sale: "Sale",
                discoverMore:"Discover More",
                yourWishlist: "Your Wishlist",
                viewSimilar:"View Similar",
                noWishlist:"You have no wishlist item.",
                cart:"Cart",
                noCart:"No cart items added",
                total:"Total",
                checkout:"Checkout",
                viewCart:"View Cart",
                yourCart:"Your Cart",
                product:"Product",
                quantity:"Quantity",
                amount:"Amount",
                cartTotal:"Cart Total",
                subTotal:"Subtotal",
                deliveryAddress:"Delivery address",
                pleaseChoose:"Please choose",
                location:"Location",
                actualLocation:"Your actual location",
                contactNum:"Contact Number",
                yourNumber:"Your Contact Number",
                deliveryCharge:"Delivery Charge",
                confirmOrder:"Confirm Order",
                orderNote:"Note: If your outside kathmandu valley delivery charges may apply and may take 7-10 days for delivey. Customers inside valley will have free delivery charge and may get your order within 3 days",
                thanksNote:"Thank you for shopping with us.",
                paymentMethod:"Choose Payment Method",
                cancel:"Cancel",
                buyNow:"Buy Now"

            },
            auth: {
                customerLogin: "Customer Login",
                rememberMe: "Remember Me",
                createAccount: "Create Your Account",
                forgotPassword: "Forgot Password?",
                clickHere: "Click Here",
                loginGoogle: "Login Using Google",
                loginFacebook: "Login With Facebook",
                getCode: "Get Code",
                registerPhone: "Register using phone number",
                loginAccount: "Login to your account",
                createAccount: "Create Account",
                enterCode: "Enter 6 digit code sent to ",
                submitCode: "Submit Code",
                resendCode: "Resend Code",
                loginAccount: "Login to your Account",
                agreeTerms: "Agree to terms and conditions"
            },
            header: {
                contact: "9815790619",
                lang: "Language",
                login: "Login",
                home: "Home",
                categories: "Categories",
                collections: "Collections",
                about: "About",
                contact: "Contact",
                topSelling: "Top Selling",
                offers: "Offers",
                sale: "Sale",
                search:"Search items here ...",
                searchBtn:"Search",
                account: "Account",
                myCart:"My Cart",
                purchaseHistory:"Purchase History",
                logout:"Logout"
            },
            detail: {
                addToCart: "Add To Cart",
                buyNow: "Buy Now",
                ratingReviews: "Rating and Reviews",
                rateProduct: "Rate this product",
                notRated: "Not Rated Yet",
                peopleRated: "people rated this",
                noReviews: "No reviews yet",
                submit: "Submit",
                description: "Description",
                relatedTags: "Related Tags",
                similarProduct: "Similar Products",
                size:"Size",
                color:"Color",
                count:"Count",
                chooseColor:"Choose Color",
                chooseSize:"Choose Size",
                ask:"Ask or write something"
            },
            footer: {
                address: "Address",
                phone: "Phone",
                email: "Email",
                usefulLinks:"Useful Links",
                joinNewsletter: "Join Our Newsletter Now",
                getEmail:
                    "Get E-mail updates about our latest shop and special offers",
                subscribe: "Subscribe",
                about: "About Us",
                privacyPolicy: "Privacy Policy",
                contact: "Contact",
                terms: "Terms"
            },
            filter: {
                filter: "Filter",
                sort: "Sort By",
                price: "Price",
                brands: "Brands",
                default: "Default",
                popularity: "Popularity",
                rating: "Average Rating",
                newest: "Newest",
                priceAsc: "Price: Low To High",
                priceDes: "Price: High To Low",
                any: "Any",
                rs: "Rs",
                above: "Above"
            },
            category:{
               "Men's Fashion":"Men's Fashion",
               "Women's Fashion":"Women's Fashion",
               "Electronics & Accessories":"Electronics & Accessories",
               "Electricals":"Electricals",
               "Home Appliances":"Home Appliances",
               "Groceries":"Groceries",
               "Health & Beauty":"Health & Beauty",
               "Gifts":"Gifts",
               "Baby Shop":"Baby Shop",
               "Automobile & Parts":"Automobile & Parts",
               "Sports":"Sports",
               "Home & Lifestyle":"Home & Lifestyle"

            },
            subcat:{

            }
        }
    },
    nep: {
        words: {
            general: {
                latestProducts: "भर्खरका उत्पादहरू",
                quickView: "द्रुत दृश्य",
                rs: "रु",
                topSellingProducts: "शीर्ष बेच्ने उत्पादनहरू",
                productOffers: "प्रस्ताव अफरको साथ",

                topSeller: "शीर्ष विक्रेताहरू",
                topBrand: "शीर्ष ब्रान्डहरू",
                productCollect: "उत्पाद संग्रह",
                sale: "बिक्री",
                discoverMore:"थप पत्ता लगाउनुहोस्",
                yourWishlist:"तपाईको ईच्छा सूची",
                viewSimilar:"समान हेर्नुहोस्",
                noWishlist:"तपाईंसँग कुनै इच्छा सूची वस्तु छैन।",
                cart:"कार्ट",
                noCart:"कुनै कार्ट आईटमहरू छैनन्",
                total:"कुल",
                checkout:"चेकआउट",
                viewCart:"कार्ट हेर्नुहोस्",
                yourCart:"तपाईंको कार्ट",
                product:"उत्पादन",
                quantity:"मात्रा",
                amount:"रकम",
                cartTotal:"कार्ट कुल",
                subTotal:"उप कुल",
                deliveryAddress:"उप कुल",
                pleaseChoose:"कृपया छनौट गर्नुहोस्",
                location:"स्थान",
                actualLocation:"तपाईंको वास्तविक स्थान",
                contactNum:"सम्पर्क नम्बर",
                yourNumber:"तपाईंको सम्पर्क नम्बर",
                deliveryCharge:"वितरण शुल्क",
                confirmOrder:"अर्डर पुष्टि गर्नुहोस्",
                orderNote:"यदि तपाई काठमाडौं उपत्यका बाहिर हुनुहुन्छ भने सामान डेलिभरी हुन ७-१० दिन लाग्छ र डेलिभरी शुल्क लाग्न सक्नेछ तर यदि तपाई काठमाडौं उपत्यका भित्र हुनुहुन्छ भने नि:शुल्क डेलिभरी पाउनुहुन्छ र सामान डेलिभरी हुन १-३ दिन मात्र लाग्छ।",
                thanksNote:"हामीसँग किनमेल गर्नु भएकोमा धन्यवाद।",
                paymentMethod:"भुक्तानी विधि छनौट गर्नुहोस्",
                cancel:"रद्द गर्नुहोस्",
                buyNow:"अहिले खरिद गर"
            },
            auth: {
                customerLogin: "ग्राहक लगइन",
                rememberMe: "मलाई सम्झनुहोस्",
                createAccount: "तपाईँका खाता बनाउनुहोस्",
                forgotPassword: "पासवर्ड भुल्नु भयो?",
                clickHere: "यहाँ क्लिक गर्नुहोस्",
                loginGoogle: "गुगल प्रयोग गरेर लगईन गर्नुहोस्",
                loginFacebook: "फेसबुकको साथ लगइन गर्नुहोस्",
                getCode: "कोड प्राप्त गर्नुहोस्",
                registerPhone: "फोन नम्बर प्रयोग गरेर दर्ता गर्नुहोस्",
                loginAccount: "तपाईको खातामा लगईन गर्नुहोस्",
                createAccount: "खाता सिर्जना गर्नुहोस्",
                enterCode:
                    "यस जीमेलमा पठाइएको digit अंकको कोड प्रविष्ट गर्नुहोस् ",
                submitCode: "कोड बुझाउनुहोस्",
                resendCode: "कोड पुन: पठाउनुहोस्",
                loginAccount: "तपाईको खातामा लगईन गर्नुहोस्",
                agreeTerms: "नियम र सर्तहरूमा सहमत गर्नुहोस्"
            },
            header: {
                contact: "9815790619",
                lang: "भाषा",
                login: "लग - इन",
                home: "मुख्य",
                categories: "प्रकार",
                collections: "संग्रह",
                about: "बारेमा",
                contact: "सम्पर्क",
                topSelling: "शीर्ष बिक्री भइरहेको",
                offers: "प्रस्तावहरू",
                sale: "बिक्री",
                search:"यहाँ आईटमहरू खोज्नुहोस्....",
                searchBtn:"खोजी गर्नुहोस्",
                account: "खाता",
                myCart:"मेरो कार्ट",
                purchaseHistory:"खरीदको इतिहास",
                logout:"खरीदको इतिहास"
            },
            detail: {
                addToCart: "कार्टमा हाल",
                buyNow: "अहिले खरिद",
                ratingReviews: "रेटिंग र समीक्षा",
                rateProduct: "मूल्याकन गर्नुहोस्",
                notRated: "अझै मूल्याकन गरिएको छैन",
                peopleRated: "मूल्याकन गरियो",
                noReviews: "अझै पूनरावलोकन भएको छैन",
                submit: "बुझाउनुहोस्",
                description: "वर्णन",
                relatedTags: "सम्बन्धित ट्यागहरू",
                similarProduct: "समान उत्पादनहरू",
                size:"आकार",
                color:"रंग",
                count:"गणना",
                chooseSize:"आकार छनौट गर्नुहोस्",
                chooseColor:"रंग छनौट गर्नुहोस्",
                ask:"सोध्नुहोस् वा केहि लेख्नुहोस्"
            },
            footer: {
                address: "ठेगाना",
                phone: "फोन",
                email: "ईमेल",
                joinNewsletter: "अब हाम्रो न्यूजलेटरमा शामिल हुनुहोस् ",
                getEmail:
                    "हाम्रो पछिल्लो पसल र विशेष प्रस्तावहरूको बारेमा ईमेल अपडेटहरू प्राप्त गर्नुहोस्",
                subscribe: "सदस्यता लिनुहोस्",
                about: "हाम्रोबारे",
                privacyPolicy: "गोपनीयता नीति",
                contact: "सम्पर्क",
                terms: "सर्तहरू",
                usefulLinks:"उपयोगी लिङ्कहरू"
            },
            filter: {
                filter: "फिल्टर",
                sort: "द्वारा क्रमबद्ध गर्नुहोस्",
                price: "मूल्य",
                brands: "ब्रान्ड",
                default: "पूर्वनिर्धारित",
                popularity: "लोकप्रियता",
                rating: "औसत रेटिंग",
                newest: "सबैभन्दा नयाँ",
                priceAsc: "मूल्य: कमदेखि उच्च",
                priceDes: "मूल्य: उच्च देखि कम",
                any: "कुनै",
                rs: "रु",
                Above: "माथि"
            },
        }
    }
};
