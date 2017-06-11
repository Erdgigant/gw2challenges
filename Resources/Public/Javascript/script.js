//Mini class
var Mini = function(list){
	this.list = list;
	this.uid = Mini.uidStorage++;
};

Mini.uidStorage = 0;

//Vue Instance
var app = new Vue({
	el: '#wrapper',
	data: {
		minis: [
			new Mini(0),
			new Mini(1)
		],
		miniStorage: null,
		filterText: ''
	},
	mounted: function(){
		var miniData = JSON.parse($('#miniData').val());		
		miniData.forEach(function(mini){
			var newMini = new Mini(0);
			newMini.id = mini.id;
			newMini.name = mini.name;
			newMini.icon = mini.icon;
			this.minis.splice(this.minis.indexOf(mini)+1, 0, newMini);
		}, this);
	},
	methods: {
		getMinisByList(list, filter = false){
			return this.minis.filter(function(val){
				if(filter && this.filterText != '' && val.name){
					return (val.list == list && val.name.indexOf(this.filterText) !== -1);
				}
				else{
					return val.list == list;
				}
			}, this);
		},
		add: function(mini) {
			this.minis.splice(this.minis.indexOf(mini)+1, 0, new Mini(mini.list));
		},
		remove: function(mini){
			this.minis.splice(this.minis.indexOf(mini), 1);
			if(!this.getMinisByList(mini.list).length){
				this.add(mini);
			}
		},
		update: function(mini){
			var id = mini.id;
			if(id != '' && !isNaN(id)) {
				console.log('Searching for mini with id ' + id);
				$.ajax({
					data: {
						lang: 'de'
					},
					url: 'https://api.guildwars2.com/v2/minis/' + id,
					method: 'GET',
					context: this,
					complete: function (result) {
						console.log('Finished for mini with id ' + id);
						var index = this.minis.indexOf(mini);
						delete this.minis[index].text;
						this.minis[index] = Object.assign({}, this.minis[index], result.responseJSON);
						this.minis = Array.from(this.minis); //Force to update
					}
				});
			}
		},
		drag: function(mini, e){
			this.miniStorage = mini;
		},
		drop: function(e){
			var index = this.minis.indexOf(this.miniStorage);
			this.minis[index].list = +e.currentTarget.id[e.currentTarget.id.length-1];
			this.miniStorage = null;
		}
	},
	computed: {
		getMinisForChallenge(){
			return this.getMinisByList(1).map(function(a){
				return a.id;
			});
		}
	},
	components: {
		Mini: {
			props: ['mini'],
			data: function() {
				return {
					dragEffect: false
				}
			},
			template: `
				<div class="mini" draggable="true" :class="{hide: mini == $parent.miniStorage, dragEffect: dragEffect}"
					@dragenter="dragEffect = true" @dragleave="dragEffect = false" @dragstart="$parent.drag(mini, $event)">

				<p class="header">
					<span @click="$parent.remove(mini)">X</span>
					<span @click="$parent.update(mini)">\u27F2</span>
					<span @click="$parent.add(mini)">+</span>
					<b v-if="mini.text">{{ mini.text }}</b>
				</p>

				<input type="text" @keyup.enter="$parent.update(mini)" v-model="mini.id"/>

				<p v-if="mini.name">{{ mini.name }}</p>

				<img v-if="mini.icon" :src="mini.icon"/>
			</div>
			`
		}
	}
});