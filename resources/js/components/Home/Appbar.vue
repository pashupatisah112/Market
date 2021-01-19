<template>
<div>
    <v-container fluid>
        <v-row class="px-5" style="background-color:rgba(0, 0, 0, 0.87)">

            <v-icon dense class="pr-1" color="white">mdi-email</v-icon>
            <p class="caption mt-4 white--text">info@onlinemarket.com</p>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-icon dense color="white">mdi-cellphone</v-icon>
            <p class="caption mt-4 white--text">9815790619</p>

            <v-spacer></v-spacer>

            <div class="hidden-sm-and-down mt-3">
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-facebook</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-twitter</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-linkedin</v-icon>
                </v-btn>
                <v-btn icon small>
                    <v-icon dense size="18" color="white">mdi-pinterest</v-icon>
                </v-btn>
            </div>

            <v-divider vertical class="my-3 mx-2 hidden-sm-and-down" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-menu offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class="mt-3 text-capitalize mx-auto">
                        <v-icon>mdi-flag-checkered</v-icon>
                        {{ $t('words.header.lang') }}

                    </v-btn>
                </template>
                <v-list dense elevation="0">
                    <v-list-item v-for="(item, index) in lang" :key="index" dense @click="setLocale(item.lang)">
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-divider vertical class="my-3 mx-2" style="border-color:rgba(255,255,255,0.2)"></v-divider>

            <v-btn v-if="!customerToken" small text depressed color="transparent" @click="loginDialog=true" class="mt-3 text-capitalize white--text mx-auto">
                <v-icon color="white">mdi-account</v-icon>
                {{ $t('words.header.login') }}
            </v-btn>
            <v-menu v-else offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn dark v-bind="attrs" v-on="on" small text depressed color="transparent" class="mt-3 text-capitalize mx-auto">
                        <v-icon>mdi-account</v-icon>
                        Account
                    </v-btn>
                </template>
                <v-expand-y-transition>
                    <v-card width="200" tile>
                        <v-card-title class="pa-2">{{this.auth.name}}</v-card-title>
                        <v-card-text class="pa-1">
                            <v-list dense>
                                <v-list-item dense>
                                    <v-list-item-content>
                                        <v-list-item-subtitle>
                                            <v-icon class="mr-2">mdi-cart</v-icon>My Cart
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-content>
                                        <v-list-item-subtitle>
                                            <v-icon class="mr-2">mdi-cards-heart</v-icon>Wishlist
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-content>
                                        <v-list-item-subtitle>
                                            <v-icon class="mr-2">mdi-history</v-icon>Purchase history
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense @click="logout">
                                    <v-list-item-content>
                                        <v-list-item-subtitle>
                                            <v-icon class="mr-2">mdi-logout</v-icon>Logout
                                        </v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-expand-y-transition>
            </v-menu>
        </v-row>

        <v-row>
            <v-toolbar extended dense short max-height="50" elevation="0" class="mb-1">
                <v-toolbar-title class="mr-12">
                    <span class="heading-3 font-weight-bold">COZA</span> Store
                </v-toolbar-title>

                <v-btn text class="text-capitalize" @click="goHome">
                    {{ $t('words.header.home') }}
                </v-btn>

                <v-menu open-on-hover bottom offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn text v-bind="attrs" v-on="on" class="text-capitalize">
                            {{ $t('words.header.categories') }}
                        </v-btn>
                    </template>
                    <v-card max-width="1200">
                        <v-container fluid>
                            <v-row>
                                <v-col co v-for="item in categories" :key="item.id">
                                    <p class="font-weight-bold">{{item.category_name}}</p>
                                    <v-btn text small class="text-capitalize" v-for="sub in item.subcategory" :key="sub.id" @click="goToList(item,sub)">{{sub.subCategory_name}}</v-btn><br>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-menu>

                <v-btn text class="text-capitalize" to="/collections">
                    {{ $t('words.header.collections') }}
                </v-btn>

                <v-btn text class="text-capitalize" to="/about">
                    {{ $t('words.header.about') }}
                </v-btn>

                <v-btn text class="text-capitalize" to="/contact">
                    {{ $t('words.header.contact') }}
                </v-btn>

                <v-spacer></v-spacer>
                <v-expand-x-transition>
                    <v-text-field rounded filled dense placeholder="Search items here..." v-show="search" v-model="searchItem" class="mt-7 mr-2"></v-text-field>
                </v-expand-x-transition>

                <v-btn icon @click="searchOptions">
                    <v-icon>mdi-account-search</v-icon>
                </v-btn>

                <v-menu bottom open-on-hover offset-y transition="expand-transition">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-cards-heart</v-icon>
                        </v-btn>
                    </template>
                    <v-card width="400">
                        <v-row class="px-5">
                            <v-card-title class="float-left">Your Wishlist</v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-subtitle class="float-right">View Similar</v-card-subtitle>
                        </v-row>

                        <v-container fluid>
                            <v-row>
                                <v-col cols="12">
                                    <v-list two-line dense>
                                        <v-list-item v-for="chat in items" :key="chat.title" dense class="mt-n4">
                                            <v-list-item-avatar tile size="60">
                                                <v-img :alt="`${chat.title} avatar`" :src="chat.avatar"></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="chat.title"></v-list-item-title>
                                                <v-list-item-subtitle>company name</v-list-item-subtitle>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-row>
                                                    <v-tooltip top>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                                <v-icon >
                                                                    mdi-eye
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>View</span>
                                                    </v-tooltip>
                                                    <v-tooltip v-model="show" top>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                                <v-icon>
                                                                    mdi-cart-plus
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Add to cart</span>
                                                    </v-tooltip>
                                                    <v-tooltip top>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn icon v-bind="attrs" v-on="on">
                                                                <v-icon>
                                                                    mdi-cancel
                                                                </v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Remove</span>
                                                    </v-tooltip>
                                                </v-row>

                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>
                                    </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-menu>

                <v-menu bottom open-on-hover offset-y transition="expand-transition">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-cart</v-icon>
                        </v-btn>
                    </template>
                    <v-card width="300">
                        <v-card-title>Your Cart</v-card-title>
                        <v-container fluid>
                            <v-row>
                                <v-col cols="12">
                                    <v-list two-line dense>
                                        <v-list-item v-for="chat in items" :key="chat.title" dense class="mt-n4">
                                            <v-list-item-avatar tile size="60">
                                                <v-img :alt="`${chat.title} avatar`" :src="chat.avatar"></v-img>
                                            </v-list-item-avatar>

                                            <v-list-item-content>
                                                <v-list-item-title v-text="chat.title"></v-list-item-title>
                                                <v-list-item-subtitle>1 x Rs.500</v-list-item-subtitle>
                                            </v-list-item-content>

                                            <v-list-item-action>
                                                <v-icon>
                                                    mdi-cancel
                                                </v-icon>
                                            </v-list-item-action>
                                        </v-list-item>
                                    </v-list>

                                    <v-divider></v-divider>
                                    <v-row class="mt-2 px-5">
                                        <P class="text-h6">TOTAL:</P>
                                        <v-spacer></v-spacer>
                                        <p class="text-h6">Rs.2000</p>
                                    </v-row>
                                    <v-btn rounded block color="blackTheme" class="text-capitalize white--text" @click="viewCart">View Cart</v-btn>
                                    <v-btn rounded block color="blackTheme" class="text-capitalize white--text my-3">Checkout</v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card>
                </v-menu>
            </v-toolbar>
        </v-row>

        <v-dialog max-width="600" v-model="loginDialog">
            <v-card>
                <v-container fluid>
                    <v-row>
                        <v-col cols="6" class="pa-0">
                            <v-img src="../images/login-background.jpg"></v-img>
                        </v-col>
                        <v-col cols="6" class="background pa-0">
                            <v-card style="height:100%" flat>
                                <div class="pa-5">
                                    <p class="text-center font-weight-bold">Customer Login</p>
                                    <v-form ref="form" v-model="valid">
                                        <v-text-field :rules="[validRules.required,validRules.email]" :error-messages="loginError" placeholder="Email" prepend-icon="mdi-email" v-model="email" rounded dense solo filled></v-text-field>
                                        <v-text-field :rules="[validRules.required,validRules.lengthMin8]" placeholder="Password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="password" rounded dense solo filled></v-text-field>
                                        <v-checkbox label="Remember me" color="red" value="red" v-model="remember_me" hide-details class="mt-n4 ml-8 mb-2"></v-checkbox>
                                    </v-form>

                                    <v-btn rounded block dark @click="login" class="mb-2">Login</v-btn>

                                    <p class="caption line-hover" @click="registerMode=true">Create your account</p>
                                    <p class="caption mt-n2">Forgot password? <span class="line-hover">Click Here</span></p>
                                    <v-row justify="center">

                                        <v-btn small class="text-capitalize mb-2 mx-auto" dark color="#ea4335" rounded>
                                            <v-icon class="mr-3" small>mdi-google</v-icon>
                                            Login using google
                                        </v-btn>
                                        <v-btn small rounded class="text-capitalize mb-2" dark color="#3b5998">
                                            <v-icon class="mr-3" small>mdi-facebook</v-icon>
                                            Login with facebook
                                        </v-btn>
                                    </v-row>
                                </div>

                                <v-expand-transition>
                                    <div v-if="registerMode" class="transition-fast-in-fast-out v-card--reveal" style="height: 100%;opacity:1">
                                        <v-card style="height:100%" flat>
                                            <div class="pa-5">
                                                <p class="text-center font-weight-bold">Create Account</p>
                                                <v-form ref="form" v-model="valid">
                                                    <v-text-field :rules="[validRules.required]" placeholder="Full Name" prepend-icon="mdi-account" v-model="name" rounded dense solo filled></v-text-field>
                                                    <v-text-field v-if="emailMode" :rules="[validRules.required,validRules.email]" :error-messages="emailError" placeholder="Email" prepend-icon="mdi-email" append-icon="mdi-phone-remove" @click:append="emailMode=false" v-model="email" rounded dense solo filled></v-text-field>
                                                    <v-text-field v-else :rules="[validRules.required,validRules.length10,validRules.numberAll]" placeholder="Phone" prepend-icon="mdi-cellphone" append-icon="mdi-email-off" @click:append="emailMode=true" v-model="phone" rounded dense solo filled></v-text-field>
                                                    <v-text-field :rules="[validRules.required,validRules.lengthMin8]" placeholder="Password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" @click:append="show1 = !show1" :type="show1 ? 'text' : 'password'" prepend-icon="mdi-lock" v-model="password" rounded dense solo filled></v-text-field>
                                                    <v-row>
                                                        <v-checkbox :rules="[v => !!v || 'You must agree to continue!']" class="mt-n2 ml-8" color="green" value="red" hide-details></v-checkbox>
                                                        <p class="text--secondary body-2">Agree to <span class="line-hover" @click="termsDialog=true">Terms and Conditions</span></p>
                                                    </v-row>
                                                    <v-btn rounded dark block @click="register" class="text-capitalize my-2">Create Account</v-btn>
                                                </v-form>
                                                <p class="caption line-hover" @click="registerMode=false">Login to your account</p>
                                            </div>
                                        </v-card>
                                    </div>
                                </v-expand-transition>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>

            </v-card>
        </v-dialog>

        <template>
            <v-row justify="center">
                <v-dialog v-model="termsDialog" width="600px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Terms and Conditions</span>
                        </v-card-title>
                        <v-card-text>
                            Lorem ipsum dolor sit amet, semper quis, sapien id natoque elit. Nostra urna at, magna at neque sed sed ante imperdiet, dolor mauris cursus velit, velit non, sem nec. Volutpat sem ridiculus placerat leo, augue in, duis erat proin condimentum in a eget, sed fermentum sed vestibulum varius ac, vestibulum volutpat orci ut elit eget tortor. Ultrices nascetur nulla gravida ante arcu. Pharetra rhoncus morbi ipsum, nunc tempor debitis, ipsum pellentesque, vitae id quam ut mauris dui tempor, aptent non. Quisque turpis. Phasellus quis lectus luctus orci eget rhoncus. Amet donec vestibulum mattis commodo, nulla aliquet, nibh praesent, elementum nulla. Sit lacus pharetra tempus magna neque pellentesque, nulla vel erat.
                            Justo ex quisque nulla accusamus venenatis, sed quis. Nibh phasellus gravida metus in, fusce aenean ut erat commodo eros. Ut turpis, dui integer, nonummy pede placeat nec in sit leo. Faucibus porttitor illo taciti odio, amet viverra scelerisque quis quis et tortor, curabitur morbi a. Enim tempor at, rutrum elit condimentum, amet rutrum vitae tempor torquent nunc. Praesent vestibulum integer maxime felis. Neque aenean quia vitae nostra, tempus elit enim id dui, at egestas pulvinar. Integer libero vestibulum, quis blandit scelerisque mattis fermentum nulla, tortor donec vestibulum dolor amet eget, elit nullam. Aliquam leo phasellus aliquam curabitur metus a, nulla justo mattis duis interdum vel, mollis vitae et id, vestibulum erat ridiculus sit pulvinar justo sed. Vehicula convallis, et nulla wisi, amet vestibulum risus, quam ac egestas.
                            Et vitae, nulla gravida erat scelerisque nullam nunc pellentesque, a dictumst cras augue, purus imperdiet non. Varius montes cursus varius vel tortor, nec leo a qui, magni cras, velit vel consectetuer lobortis vel. Nibh erat et wisi felis leo porttitor, sapien nibh sapien pede mi, sed eget porttitor, repellendus arcu ac quis. Luctus vulputate aut est sem magna, placerat accumsan nunc vestibulum ipsum ac auctor, maecenas lorem in ut nec mauris tortor, doloribus varius sem tortor vestibulum mollis, eleifend tortor felis tempus lacus eu eu. Eleifend vel eu, nullam maecenas mauris nec nunc euismod, tortor porta ridiculus potenti, massa tristique nam magna, et wisi placerat et erat ante. Eget pede erat in facilisis, fermentum venenatis sodales. Ac tortor sociis et non animi tristique, rhoncus malesuada, ut arcu volutpat scelerisque sollicitudin, elit curabitur dui pede purus dolor, integer aenean risus taciti nulla eleifend accumsan. At pulvinar diam parturient, interdum mi velit aliquet et a. Arcu at ac placerat eget justo semper, purus sociis curabitur mi ipsum consequat ut, mollis vestibulum, est ante ornare lacus sem. Neque magna mauris, commodo quisque, praesent semper suscipit lobortis nam. Justo malesuada cursus ac nunc litora nunc. Tellus ac, in lobortis nunc, montes lectus purus fermentum.
                            Ac sit wisi. Sodales aliquam, sed vestibulum nullam arcu sit risus arcu, id luctus vitae lorem nibh, integer nec nullam class cursus mi, purus arcu lectus. Vel ante suscipit volutpat potenti mattis sed, wisi eu placerat aliquam erat, lectus morbi lobortis at assumenda. Consequat neque purus ipsum voluptas odio, netus vestibulum ut nec, suspendisse pellentesque nec enim in. Wisi dictum sed semper a, ipsum erat tellus habitasse est, erat sem ornare, vitae quisque ultricies. Dui sed blandit. Tempor et faucibus justo sed luctus, nec vitae vitae. Nunc nibh pede, ipsum vestibulum aenean leo ante ultricies, nam cras quis sed penatibus amet. In mauris a. Integer metus mauris tortor, et rutrum vestibulum ultricies, ut phasellus in ullamcorper ut mollit, eu justo. Cursus pretium venenatis.
                            Cras pellentesque vel sodales accumsan aenean. Feugiat metus sit nec in aliquet amet, porttitor pretium vulputate massa. Consequat ipsum luctus quisque adipiscing libero. Wisi sollicitudin. Eget vitae ac lobortis, lorem natoque vestibulum et, aliquet faucibus at morbi nibh, vel condimentum. Massa unde orci sed id sed, odio donec congue nec praesent amet. Hymenaeos velit lacus, quis vivamus libero tempus duis, eu nisi eu, ipsum at accumsan pede justo morbi donec, massa et libero sit risus neque tortor. Ut sed sed etiam hendrerit dapibus, quis metus suspendisse nibh.
                            Fringilla tempor felis augue magna. Cum arcu a, id vitae. Pellentesque pharetra in cras sociis adipiscing est. Nibh nec mattis at maecenas, nisl orci aliquam nulla justo egestas venenatis, elementum duis vel porta eros, massa vitae, eligendi imperdiet amet. Nec neque luctus suscipit, justo sem praesent, ut nisl quisque, volutpat torquent wisi tellus aliquam reprehenderit, curabitur cras at quis massa porttitor mauris. Eros sed ultrices. Amet dignissim justo urna feugiat mauris litora, etiam accumsan, lobortis a orci suspendisse. Semper ac mauris, varius bibendum pretium, orci urna nunc ullamcorper auctor, saepe sem integer quam, at feugiat egestas duis. Urna ligula ante. Leo elementum nonummy. Sagittis mauris est in ipsum, nulla amet non justo, proin id potenti platea posuere sit ut, nunc sit erat bibendum. Nibh id auctor, ab nulla vivamus ultrices, posuere morbi nunc tellus gravida vivamus.
                            Mauris nec, facilisi quam fermentum, ut mauris integer, orci tellus tempus diam ut in pellentesque. Wisi faucibus tempor et odio leo diam, eleifend quis integer curabitur sit scelerisque ac, mauris consequat luctus quam penatibus fringilla dis, vitae lacus in, est eu ac tempus. Consectetuer amet ipsum amet dui, sed blandit id sed. Tellus integer, dignissim id pede sodales quis, felis dolorem id mauris orci, orci tempus ut. Nullam hymenaeos. Curabitur in a, tortor ut praesent placerat tincidunt interdum, ac dignissim metus nonummy hendrerit wisi, etiam ut.
                            Semper praesent integer fusce, tortor suspendisse, augue ligula orci ante asperiores ullamcorper. In sit per mi sed sed, mi vestibulum mus nam, morbi mauris neque vitae aliquam proin senectus. Ac amet arcu mollis ante congue elementum, inceptos eget optio quam pellentesque quis lobortis, sollicitudin sed vestibulum sollicitudin, lectus parturient nullam, leo orci ligula ultrices. At tincidunt enim, suspendisse est sit sem ac. Amet tellus molestie est purus magna augue, non etiam et in wisi id. Non commodo, metus lorem facilisi lobortis ac velit, montes neque sed risus consectetuer fringilla dolor. Quam justo et integer aliquam, cursus nulla enim orci, nam cursus adipiscing, integer torquent non, fringilla per maecenas. Libero ipsum sed tellus purus et. Duis molestie placerat erat donec ut. Dolor enim erat massa faucibus ultrices in, ante ultricies orci lacus, libero consectetuer mauris magna feugiat neque dapibus, donec pretium et. Aptent dui, aliquam et et amet nostra ligula.
                            Augue curabitur duis dui volutpat, tempus sed ut pede donec. Interdum luctus, lectus nulla aenean elit, id sit magna, vulputate ultrices pellentesque vel id fermentum morbi. Tortor et. Adipiscing augue lorem cum non lacus, rutrum sodales laoreet duis tortor, modi placerat facilisis et malesuada eros ipsum, vehicula tempus. Ac vivamus amet non aliquam venenatis lectus, sociosqu adipiscing consequat nec arcu odio. Blandit orci nec nec, posuere in pretium, enim ut, consectetuer nullam urna, risus vel. Nullam odio vehicula massa sed, etiam sociis mauris, lacus ullamcorper, libero imperdiet non sodales placerat justo vehicula. Nec morbi imperdiet. Fermentum sem libero iaculis bibendum et eros, eget maecenas non nunc, ad pellentesque. Ut nec diam elementum interdum. Elementum vitae tellus lacus vitae, ipsum phasellus, corporis vehicula in ac sed massa vivamus, rutrum elit, ultricies metus volutpat.
                            Semper wisi et, sollicitudin nunc vestibulum, cursus accumsan nunc pede tempus mi ipsum, ligula sed. Non condimentum ac dolor sit. Mollis eu aliquam, vel mattis mollis massa ut dolor ante, tempus lacinia arcu. Urna vestibulum lorem, nulla fermentum, iaculis ut congue ac vivamus. Nam libero orci, pulvinar nulla, enim pellentesque consectetuer leo, feugiat rhoncus rhoncus vel. Magna sociosqu donec, dictum cursus ullamcorper viverra. Ultricies quis orci lorem, suspendisse ut vestibulum integer, purus sed lorem pulvinar habitasse turpis.
                            +
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="termsDialog = false">
                                Close
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>

    </v-container>
</div>
</template>

<script>
import {
    mapState
} from 'vuex';
import {
    mapFields
} from 'vuex-map-fields';
export default {
    data() {
        return {
            termsDialog: '',
            customerToken: false,
            show1: false,
            loginDialog: false,
            registerMode: false,
            emailMode: true,
            valid: true,
            remember_me: false,
            email: null,
            loginError: '',
            emailError: '',
            password: '',
            name: '',
            phone: null,
            search: false,
            searchItem: null,
            selectedLang: '',
            categories: [],
            menus: [{
                    title: 'Home',
                    link: ''
                },
                {
                    title: 'Categories',
                    link: ''
                },
                {
                    title: 'Collections',
                    link: ''
                },
                {
                    title: 'About Us',
                    link: ''
                },
                {
                    title: 'Contact',
                    link: ''
                },

            ],
            items: [{
                    active: true,
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
                    title: 'Jason Oner',
                },
                {
                    active: true,
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
                    title: 'Mike Carlson',
                },
                {
                    avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                    title: 'Cindy Baker',
                },
            ],
            lang: [{
                    title: 'English',
                    lang: 'en'
                },
                {
                    title: 'Nepali',
                    lang: 'nep'
                },
            ],
        }
    },
    computed: {
        ...mapState({
            'validRules': state => state.validation.validRules
        }),
        ...mapState(['auth']),
        ...mapFields(['auth'])
    },
    created() {
        this.checkUser()
        this.getCategories()
    },
    methods: {
        checkUser() {
            if (localStorage.getItem('customer-token')) {
                this.customerToken = true
            }
        },
        goToList(item, sub) {
            this.$router.push({
                name: 'Category',
                params: {
                    category: item.category_name,
                    subCategory: sub.subCategory_name
                }
            });
        },
        searchOptions() {
            if (this.search == false) {
                this.search = true
            } else {
                if (this.searchItem == null) {
                    this.search = false
                } else {
                    console.log('search item')
                }

            }
        },
        viewCart() {
            this.$router.push({
                name: 'Cart'
            })
        },
        setLocale(language) {
            this.$store.dispatch('changeLocale', language)
                .then(() => {
                    this.$i18n.locale = language;
                }).catch((error => {}));
        },
        login() {
            if (this.$refs.form.validate()) {
                axios
                    .post("/api/customer-login", {
                        email: this.email,
                        password: this.password,
                        remember_me: this.remember_me
                    })
                    .then(res => {
                        localStorage.setItem("customer-token", res.data.token);
                        this.auth = res.data.auth_user
                        window.location.reload()
                            .catch(err => console.log(err));
                    })
                    .catch(err => {
                        this.loginError = err.response.data.status
                    });
            }
        },
        register() {
            if (this.$refs.form.validate()) {
                axios.post('/api/register', {
                        'name': this.name,
                        'email': this.email,
                        'phone': this.phone,
                        'password': this.password,
                        'role_id': 2,
                    })
                    .then(res => {
                        localStorage.setItem("customer-token", res.data.token);
                        this.auth = res.data.auth_user
                        window.location.reload()
                            .catch(err => console.log(err));
                    }).catch(err => {
                        this.emailError = err.response.data.errors.email[0]
                    })
            }
        },
        logout: function () {
            localStorage.removeItem('customer-token');
            localStorage.clear()
            window.location.reload()
        },
        goHome() {
            this.$router.push({
                name: 'Home',
            })
        },
        getCategories() {
            axios.get('api/getCategories')
                .then(res => {
                    this.categories = res.data
                })
                .catch(err => console.log(err.response))
        }
    }
}
</script>
