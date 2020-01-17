/*!
 DMXzone Bootstrap 4 Modal
 Version: 1.0.1
 (c) 2019 DMXzone.com
 @build 2019-04-02 10:36:56
 */
dmx.Component("bs4-modal",{attributes:{nobackdrop:{type:Boolean,default:!1},nocloseonclick:{type:Boolean,default:!1},nokeyboard:{type:Boolean,default:!1},nofocus:{type:Boolean,default:!1},show:{type:Boolean,default:!1}},methods:{toggle:function(){jQuery(this.$node).modal("toggle")},show:function(){jQuery(this.$node).modal("show")},hide:function(){jQuery(this.$node).modal("hide")},update:function(){jQuery(this.$node).modal("handleUpdate")}},events:{show:Event,shown:Event,hide:Event,hidden:Event},render:function(o){this.$node=o,this.$parse(),jQuery(o).on("show.bs.modal",this.dispatchEvent.bind(this,"show")),jQuery(o).on("shown.bs.modal",this.dispatchEvent.bind(this,"shown")),jQuery(o).on("hide.bs.modal",this.dispatchEvent.bind(this,"hide")),jQuery(o).on("hidden.bs.modal",this.dispatchEvent.bind(this,"hidden")),this.update({})},update:function(o){JSON.stringify(o)!=JSON.stringify(this.props)&&jQuery(this.$node).modal({backdrop:!this.props.nobackdrop&&this.props.nocloseonclick?"static":!this.props.nobackdrop,keyboard:!this.props.nokeyboard,focus:!this.props.nofocus,show:!!this.props.show})},beforeDestroy:function(){jQuery(this.$node).off(".bs.modal"),jQuery(this.$node).modal("dispose")}});
//# sourceMappingURL=../maps/dmxBootstrap4Modal.js.map
