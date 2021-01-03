import Axios from "axios";
import router from "../router";
import store from "./mainStore";
export default {
    state: {
        //used in postcreate and feed
        posts:[],
        feed:'',

        //post create
        config: {
            language: 'en', // localization
            placeholderText: "Share what you've got",
            zIndex: 2501,
            charCounterMax: 5000,
            toolbarSticky: false,
            quickInsertEnabled: false,
            heightMin: 200,
            // imageUpload:true,
            // imageMaxSize:5*1024*1024,
            // imageUploadURL: 'api/uploadImage',
            // imageUploadParam:'image_param',
            // imageUploadMethod:'post',
            // imageUploadParams:{
            //     froala:true,
            //     _token:"{{csrf_token()}}"
            // },

            toolbarButtons: {
                // name for block of buttons

                moreParagraph: {
                    buttons: ['paragraphFormat', 'formatOLSimple', 'formatUL', 'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'lineHeight', 'outdent', 'indent', 'quote'],
                    align: 'left',
                    buttonsVisible: 1
                },
                moreText: {
                    // buttons you need on this block
                    buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontSize', 'textColor', 'inlineClass', 'backgroundColor', 'clearFormatting'],
                    align: 'left',
                    buttonsVisible: 3
                },
                moreRich: {
                    buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'specialCharacters', 'horizontalLine'],
                    align: 'left',
                    buttonsVisible: 3
                },
            },
            imageEditButtons: ['imageReplace', 'imageAlign', 'imageCaption', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'],

            model: 'Edit Your Content Here!',
            events: {
                "image.beforeUpload": function (files) {
                    var editor = this;
                    if (files.length) {
                        // Create a File Reader.
                        var reader = new FileReader();
                        // Set the reader to insert images when they are loaded.
                        reader.onload = function (e) {
                            var result = e.target.result;
                            editor.image.insert(result, null, null, editor.image.get());
                        };
                        // Read image as base64.
                        reader.readAsDataURL(files[0]);
                    }
                    editor.popups.hideAll();
                    // Stop default upload chain.
                    return false;
                }
            }

        },
        
        //alert messages
        alertCommunity: false,
        alertIcon: "mdi-information",
        alertType: "success",
        alertBtn1: "Go",
        showAlertButton1: false,
        alertBtn2: "Close",
        showAlertButton2: false,
        alertMessage:
            "<strong>You</strong> and <strong>Sabina</strong> are now mates.",

        request_add_icon: "mdi-account-plus",
        request_sent_icon: "mdi-account-check",
        chatDialog: false,

        chat: false,
        rooms: [],
        chatMessages:[]
    },
    mutations: {
        getAlert(state, item) {
            state.alertCommunity = true;
            state.alertIcon = "mdi-account-multiple";
            state.alertMessage =
                "<strong>You</strong> and <strong>" +
                item.sender_name +
                "</strong> are now mates.";
            setTimeout(() => {
                state.alertCommunity = false;
            }, 2000);
        },
        closeAlert(state) {
            state.alertCommunity = false;
        },
        getProfile(item) {
            return "../storage/" + item.profile;
        },
        startChat(state, payload) {
            if (!state.rooms.includes(payload)) {
                state.rooms.push(payload);
            }
            state.chat = true;
        },
        closeChat(state, payload) {
            const index = state.rooms.indexOf(payload);
            state.rooms.splice(index);
            state.chatMessages.splice(index);
            if (state.rooms.length < 1) {
                state.chat = false;
            }
        },
        
    },
    actions: {
        followTutor(context, payload) {
            console.log(payload);
        },
        getImage(context, payload) {
            return "../storage/" + payload;
        },
        getMessages(context,item) {
            let auth_id = JSON.parse(context.rootState.auth).id
            let user_id = item.id

            let doc_id = null

            if (auth_id < user_id) {
                doc_id = auth_id + "and" + user_id
            } else {
                doc_id = user_id + "and" + auth_id
            }
            console.log(doc_id)

            db.collection("message").doc(doc_id).collection("messages").onSnapshot((querySnapshot) => {
                let data = []

                querySnapshot.forEach((doc) => {
                    data.push(doc.data())
                });
                context.state.chatMessages.push(data)
                //this.messages.push(data)
                console.log('module:',context.state.chatMessages)
            })
        },
    },
    getters: {}
};
