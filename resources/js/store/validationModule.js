export default{

    state:{
        validRules:{
            required: value => !!value || "Required.",
            lengthMin8: v => v && v.length >= 8 || "Min 8 characters",
            lengthMax250: v =>  v && v.length <= 250 || "Maximum 250 characters",
            length6: v =>  v && v.length == 6 || "Must be 6 characters",
            length10: v =>  v && v.length == 10 || "Must be 10 characters",
            uppercase1: v => /(?=.*[A-Z])/.test(v) || 'Must have one uppercase',
            number1: v => /(?=.*\d)/.test(v) || 'Must have one number',
            email: v => /.+@.+\..+/.test(v) || "E-mail must be valid",
            img_size: value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!',
        },      
    }
}