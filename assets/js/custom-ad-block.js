wp.blocks.registerBlockType('rzufil/custom-ad-block', {
  title: 'Custom Ad Block',
  icon: 'smiley',
  category: 'common',
  attributes: {
    adType: {
      type: 'string'
    },
    template: {
      type: 'string'
    },
    title: {
      type: 'string'
    },
    backgroundColor: {
      type: 'string'
    },
    countdownDate: {
      type: 'string'
    },
  },

  edit: function(props) {
    function updateAdType(event) {
      props.setAttributes({adType: event.target.value})
    }

    function updateTemplate(event) {
      props.setAttributes({template: event.target.value})
    }

    function updateTitle(event) {
      props.setAttributes({title: event.target.value})
    }

    function updateBackgroundColor(event) {
      props.setAttributes({backgroundColor: event.target.value})
    }

    function updateCountdownDate(date) {
      props.setAttributes({countdownDate: new Date(date)})
    }
    return wp.element.createElement(
      "div",
      { className: "custom-ad-block-settings" }, 
      wp.element.createElement("h6", null, "Type"),
      wp.element.createElement("select", { onChange: updateAdType, value: props.attributes.adType },
        wp.element.createElement("option", {value: "" }, "Select ad type..."),
        wp.element.createElement("option", {value: "default" }, "Default"),
        wp.element.createElement("option", {value: "pick" }, "Pick"),
      ),
      wp.element.createElement("h6", null, "Title"),
      wp.element.createElement("input", { type: "text", placeholder: "Ad Title", value: props.attributes.title, onChange: updateTitle }),
      wp.element.createElement("h6", null, "Template"),
      wp.element.createElement("select", { onChange: updateTemplate, value: props.attributes.template },
        wp.element.createElement("option", {value: "" }, "Select ad template..."),
        wp.element.createElement("option", {value: "default" }, "Default"),
        wp.element.createElement("option", {value: "pick" }, "Pick"),
      ),
      wp.element.createElement("h6", null, "Background Color"),
      wp.element.createElement("input", { type: "text", placeholder: "Background Color", value: props.attributes.backgroundColor, onChange: updateBackgroundColor }),
      wp.element.createElement("h6", null, "Countdown Date"),
      wp.element.createElement(wp.components.DatePicker, { currentDate: typeof props.attributes.countdownDate !== 'undefined' ? new Date(props.attributes.countdownDate) : new Date(), onChange: updateCountdownDate }),
    );
  },
  save: function(props) {
    return null;
  }
})