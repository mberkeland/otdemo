<template>
  <div id="session" @error="errorHandler">
    <publisher :session="session" @error="errorHandler" :opts="opts"></publisher>
    <div id="subscribers" v-for="stream in streams" :key="stream.streamId">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <subscriber @error="errorHandler" :stream="stream" :session="session" :opts="opts"></subscriber>
    </div>
  </div>
</template>

<script>
import OT from "@opentok/client";
import Publisher from "./Publisher.vue";
import Subscriber from "./Subscriber.vue";

const errorHandler = err => {
  alert(err.message);
};

export default {
  name: "session",
  components: {
    Publisher,
    Subscriber,

  },
  props: {
    sessionId: {
      type: String,
      required: true
    },
    token: {
      type: String,
      required: true
    },
    apiKey: {
      type: String,
      required: true
    }
  },
  created() {
    this.session = OT.initSession(this.apiKey, this.sessionId);
    this.session.connect(this.token, err => {
      if (err) {
        errorHandler(err);
      }
    });
    this.session.on("streamCreated", event => {
      this.streams.push(event.stream);
    });
    this.session.on("streamDestroyed", event => {
      const idx = this.streams.indexOf(event.stream);
      if (idx > -1) {
        this.streams.splice(idx, 1);
      }
    });
  },
  data() {
    return {
      streams: [],
      session: null,
      opts: {
        width: 400,
        height: 300
      }
    };
  },
  methods: {
    errorHandler
  },
  beforeDestroy() {
    this.session.disconnect();
  }
};
</script>

<style>
.OT_subscriber {
  float: left;
}

.OT_publisher {
  float: left;
}
</style>
