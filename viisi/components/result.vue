<template lang="pug">
  div.result(:class="{'compact-result': compactView}")
    div.result-link
      div.social-links
        span {{ __i("share-result")}}
        span(v-if="!$store.state.visuallyImpairedMode")
          a(v-for="(value, key) in $store.state.socialNetworks", :key="key", :href="value.replace('$link$',resultUrl)" , target="_blank")
            i(:class="key")
      div.link(:data-balloon-visible="copyTooltipShown", :data-balloon="copyTooltipShown ? __i('link-copied') : false", data-balloon-pos="down", @click="toggleCopyTooltip(false)", @mouseleave="toggleCopyTooltip(true)")
        i.w-icon-paper-clip
        input(type="text", :value="resultUrl", @focus="$event.target.select()")
      div.remarks
        div.remarks-header {{ __i('remark-placeholder') }}
          span(v-if="$store.state.remarksAdded && remarks.length > 0") {{ " - " + __i('result-remarks-added') }}
        textarea(v-model="remarks",maxlength="3000",:placeholder="__i('remark-placeholder-saving')", @blur="updateRemark", @mouseleave="updateRemark", @input="resetRemarksAdded")
    distribution(v-for="(selection, selection_key) in selections", :key="selection_key",:name="selection.distro.name", :description="selection.distro.description", :reasons="selection.reasons", :fgColor="selection.distro.fgColor", :bgColor="selection.distro.bgColor", :id="selection.distro.identifier", :selection="selection.selection", :url="selection.distro.url", :class="{'compact-distribution': compactView}")

    div(v-if="isEmpty")
      h1 {{ __i("no-results")}}
      p {{ __i("no-results-text")}}
</template>
<script>
import distribution from '~/components/distribution'
import i18n from '~/mixins/i18n'
import score from '~/mixins/score'
export default {
  components: {
    distribution
  },
  mixins: [i18n, score],
  data: function() {
    return {
      compactView: false,
      remarks: '',
      copyTooltipShown: false
    }
  },
  computed: {
    resultUrl: function() {
      if (this.$store.state.visuallyImpairedMode) {
        return this.$store.state.result.url + '?vim=true'
      }
      return this.$store.state.result.url
    },
    selections: function() {
      const _t = this
      const sortedSelections = this.$store.state.result.selections
        .concat()
        .sort(function(a, b) {
          return _t.scoreCompare(a.reasons, b.reasons)
        })
      console.log(sortedSelections)
      return sortedSelections
    },
    isEmpty: function() {
      var nonEmpty = 0
      this.selections.forEach(element => {
        if (element.reasons.length !== 0) {
          nonEmpty++
        }
      })
      return nonEmpty === 0
    }
  },
  methods: {
    resetRemarksAdded: function() {
      this.$store.commit('resetRemarksAdded')
    },
    updateRemark: function() {
      const resultToken = this.$store.state.result.token
      const sessionToken = this.$store.state.sessionToken
      const remarks = this.remarks
      if (this.$store.state.remarksAdded || remarks.length === 0) {
        return
      }
      this.$store.dispatch('addRemarks', {
        data: {
          sessionToken: sessionToken,
          result: resultToken,
          remarks: remarks
        }
      })
    },
    toggleCopyTooltip: function(forceHide) {
      const shouldBeShown = !this.copyTooltipShown && !forceHide
      if (shouldBeShown) {
        navigator.clipboard.writeText(this.$store.state.result.url)
      }
      this.copyTooltipShown = !this.copyTooltipShown && !forceHide
    }
  }
}
</script>

<style lang="scss">
@import '~/scss/variables.scss';
@import '~/node_modules/balloon-css/balloon.min.css';
.result {
  width: 70%;
  margin-right: 15%;
  margin-left: 15%;
  height: 25em;
  font-family: 'Open Sans', sans-serif;
}
.compact-result {
  width: unset;
  margin-right: unset;
}
.link {
  margin-top: 1em;
  font-family: Open Sans, sans-serif;
}
.link input {
  width: 50%;
  text-align: center;
  height: 36px;
  padding-top: 0px;
  padding-bottom: 3px;
  border: 0px;
  cursor: pointer;
}
.result-link {
  text-align: center;
  margin-bottom: 1em;
}
.social-links i {
  margin-left: 1em;
}
.compact-distribution {
  display: inline-grid;
  width: 47%;
  height: auto;
  margin-right: 3%;
}
.view-settings {
  text-align: center;
  margin-bottom: 1em;
}
.view-settings a {
  color: $linkColor;
  text-decoration: none;
  padding-right: 1em;
}
.remarks {
  margin-top: 1.5em;
  padding-bottom: 0.5em;
  border-bottom: 1px solid $lightAccent;
  margin-bottom: 1.5em;
}
.remarks textarea {
  width: 100%;
  margin-top: 1em;
  margin-bottom: 1em;
  font-family: 'Open Sans', sans-serif;
  resize: none;
  padding: 1em;
  resize: vertical;
  border: 0px;
  padding-top: 5em;
}
.add-remarks-button {
  border: 0px;
  color: white;
  padding: 0.7em;
  background: $linkColor;
  cursor: pointer;
}
.disabled {
  cursor: no-drop;
  background: white;
  color: black;
  border: 1px solid black;
}
.info-box {
  margin-top: 1em;
  margin-bottom: 1em;
  background: white;
  padding: 0.5em;
  background: $infoBoxBackground;
  color: white;
}
.social-links a {
  text-decoration: none;
}
.w-icon-facebook {
  color: #4267b2;
}
.w-icon-twitter {
  color: #1da1f2;
}
.w-icon-reddit {
  color: #ff4500;
}
.w-icon-paper-clip {
  padding: 10px;
  margin-right: 0px;
  color: white;
  background: $linkColor;
  vertical-align: middle;
  cursor: pointer;
}
.remarks-header {
  border: 1px solid black;
  width: 103%;
  margin-left: -1.5%;
  padding: 0.6em;
  margin-bottom: -4.7em;
  z-index: 100000000000;
  position: relative;
  background: #05396b;
  color: white;
  text-align: left;
  margin-top: 2.5em;
}
.w-icon-check-square {
  vertical-align: middle;
  margin-left: 0.4em;
  font-size: 11pt;
}
</style>
