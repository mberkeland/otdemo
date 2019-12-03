<template lang="html">
<section class="opentokDemo">
    <h3>OpenTok Demo</h3>
    <div>
        <div>
            Number to send invitation to:
            <vue-phone-number-input :default-country-code="nexmo.region" v-model="prettyNumber" @update="onUpdate" />
            <button label="Send the Invitation" primary app @click="sendText" :disabled="(!message) || (!numberStuff.isValid)">Send the Invitation</button>
            <br>
            <div>
                <h4>
                    <a target="_blank" style="display: block; width:250px;" :href="url">Or, click here to add a new client window</a>
                </h4>
            </div>
        </div>
        <div>
            <session v-if="gotToken" :nexmo="nexmo" :sessionId="sessionId" :token="token" :apiKey="nexmo.tokbox_key" />
        </div>
    </div>
</section>
</template>

<script lang="js">
import {
    parsePhoneNumberFromString
} from 'libphonenumber-js';
import {
    $BASE
} from '../../base';
import session from "./Session";
import axios from 'axios';
export default {
    name: 'opentokDemo',
    props: {
        nexmo: {
            type: Object,
            required: false
        }
    },
    data() {
        return {
            number: '',
            prettyNumber: '',
            numberStuff: {},
            incoming: [],
            message: 'Please join me in a Video Chat ',
            sessionId: '',
            token: '',
            gotToken: 0,
            url: '',
            HTTPDEMO: {},
        }
    },
    components: {
        "session": session,
    },
    methods: {
        sendText() {
            console.log("To " + this.number + " we send: " + this.message);
            let message = this.message + " " + this.url;
            this.HTTPDEMO.post('otDemo.php/send', {
                to: this.number,
                message: message
            });
            alert('The Text Invitation has been sent to ' + this.numberStuff.formatInternational + '.');
        },
        async register() {
            console.log("Registering the Demo Component with the associated backend");
            const {
                data
            } = await this.HTTPDEMO.post('otDemo.php/register', {});
            this.sessionId = data.sessionId;
            this.token = data.token;
            this.gotToken = 1;
            console.log("Got SessionID=" + this.sessionId + " Token=" + this.token);
            this.url = $BASE + "/otDemo.php/show?session=" + this.sessionId;
        },
        onUpdate(payload) {
            this.numberStuff = payload;
            if (payload.isValid) {
                this.number = this.numberStuff.formattedNumber.replace(/\D/g, '');;
            }
        },
    },
    created() {
        this.HTTPDEMO = axios.create({
            baseURL: $BASE,
            headers: {
                'Content-Type': 'application/json'
            }
        })
        this.register();
        this.prettyNumber = parsePhoneNumberFromString("+" + this.nexmo['phone']).formatNational();
    },
}
</script>

<style scoped lang="scss">
</style>
