var buzz = {
	defaults: {
		autoplay: false,
		duration: 5000,
		formats: [],
		loop: false,
		placeholder: '--',
		preload: 'metadata',
		volume: 80
	},
	types: {
		'mp3': 'audio/mpeg',
		'ogg': 'audio/ogg',
		'wav': 'audio/wav',
		'aac': 'audio/aac',
		'm4a': 'audio/x-m4a'
	},
	sounds: [],
	el: document.createElement( 'audio' ),

	sound: function( src, options ) {
		var options = options || {},
			pid = 0,
			events = [],
			eventsOnce = {},
			playedYet = false, // le son a déjà été lancé ?
			supported = buzz.isSupported();

		// publics
		this.load = function() {
			if ( !supported ) return this;

			this.sound.load();
			return this;
		}

		this.play = function() {
			if ( !supported ) return this;
			this.sound.playedYet = true;
			this.sound.play();
			return this;
		}

		// Première fois que le son est lancé ?
		this.isFirstPlay = function() {
			return !this.sound.playedYet;
		}

		this.togglePlay = function() {
			if ( !supported ) return this;

			if ( this.sound.paused ) {
				this.sound.play();
			} else {
				this.sound.pause();
			}
			return this;
		}


		this.togglePlayStop = function() {
			if ( !supported ) return this;

			if ( this.isPaused() || this.isEnded()) {
				this.play();
			} else {
				this.setTime( 0 );
				this.pause();
			}
			return this;
		}

		this.isPlaying = function() {
			return !this.isPaused() && !this.isEnded();
		}


		this.pause = function() {
			if ( !supported ) return this;

			this.sound.pause();
			return this;
		}

		this.isPaused = function() {
			if ( !supported ) return null;

			return this.sound.paused;
		}

		this.stop = function() {
			if ( !supported  ) return this;

			this.setTime( this.getDuration() );
			this.sound.pause();
			return this;
		}

		this.isEnded = function() {
			if ( !supported ) return null;

			return this.sound.ended;
		}



		this.mute = function() {
			if ( !supported ) return this;

			this.sound.muted = true;
			return this;
		}

		this.unmute = function() {
			if ( !supported ) return this;

			this.sound.muted = false;
			return this;
		}

		this.toggleMute = function() {
			if ( !supported ) return this;

			this.sound.muted = !this.sound.muted;
			return this;
		}

		this.isMuted = function() {
			if ( !supported ) return null;

			return this.sound.muted;
		}

		this.setVolume = function( volume ) {
			if ( !supported ) return this;

			if ( volume < 0 ) volume = 0;
			if ( volume > 100 ) volume = 100;
			this.volume = volume;
			this.sound.volume = volume / 100;
			return this;
		},

		this.setTime = function( time ) {
			if ( !supported ) return this;

			this.whenReady( function() {
				this.sound.currentTime = time;
			});
			return this;
		}


		this.getDuration = function() {
			if ( !supported ) return null;

			var duration = Math.round( this.sound.duration * 100 ) / 100;
			return isNaN( duration ) ? buzz.defaults.placeholder : duration;
		}

		this.getPlayed = function() {
			if ( !supported ) return null;

			return timerangeToArray( this.sound.played );
		}

		this.getBuffered = function() {
			if ( !supported ) return null;

			return timerangeToArray( this.sound.buffered );
		}

		this.getSeekable = function() {
			if ( !supported ) return null;

			return timerangeToArray( this.sound.seekable );
		}

		this.getErrorCode = function() {
			if ( supported && this.sound.error ) {
				return this.sound.error.code;
			}
			return 0;
		}

		this.getErrorMessage = function() {
			if ( !supported ) return null;

			switch( this.getErrorCode() ) {
				case 1:
					return 'MEDIA_ERR_ABORTED';
				case 2:
					return 'MEDIA_ERR_NETWORK';
				case 3:
					return 'MEDIA_ERR_DECODE';
				case 4:
					return 'MEDIA_ERR_SRC_NOT_SUPPORTED';
				default:
					return null;
			}
		}

		this.getStateCode = function() {
			if ( !supported ) return null;

			return this.sound.readyState;
		}

		this.getStateMessage = function() {
			if ( !supported ) return null;

			switch( this.getStateCode() ) {
				case 0:
					return 'HAVE_NOTHING';
				case 1:
					return 'HAVE_METADATA';
				case 2:
					return 'HAVE_CURRENT_DATA';
				case 3:
					return 'HAVE_FUTURE_DATA';
				case 4:
					return 'HAVE_ENOUGH_DATA';
				default:
					return null;
			}
		}

		this.getNetworkStateCode = function() {
			if ( !supported ) return null;

			return this.sound.networkState;
		}

		this.getNetworkStateMessage = function() {
			if ( !supported ) return null;

			switch( this.getNetworkStateCode() ) {
				case 0:
					return 'NETWORK_EMPTY';
				case 1:
					return 'NETWORK_IDLE';
				case 2:
					return 'NETWORK_LOADING';
				case 3:
					return 'NETWORK_NO_SOURCE';
				default:
					return null;
			}
		}

		this.set = function( key, value ) {
			if ( !supported ) return this;

			this.sound[ key ] = value;
			return this;
		}

		this.get = function( key ) {
			if ( !supported ) return null;

			return key ? this.sound[ key ] : this.sound;
		}

		this.bind = function( types, func ) {
			if ( !supported ) return this;

			var that = this,
				types = types.split( ' ' ),
				efunc = function( e ) { func.call( that, e ) };

			for( var t = 0; t < types.length; t++ ) {
				var type = types[ t ],
					idx = type;
					type = idx.split( '.' )[ 0 ];

					events.push( { idx: idx, func: efunc } );
					this.sound.addEventListener( type, efunc, true );
			}
			return this;
		}

		this.unbind = function( types ) {
			if ( !supported ) return this;

			var types = types.split( ' ' );

			for( var t = 0; t < types.length; t++ ) {
				var idx = types[ t ];
					type = idx.split( '.' )[ 0 ];

				for( var i = 0; i < events.length; i++ ) {
					var namespace = events[ i ].idx.split( '.' );
					if ( events[ i ].idx == idx || ( namespace[ 1 ] && namespace[ 1 ] == idx.replace( '.', '' ) ) ) {
						this.sound.removeEventListener( type, events[ i ].func, true );
						delete events[ i ];
					}
				}
			}
			return this;
		}

		this.bindOnce = function( type, func ) {
			if ( !supported ) return this;

			var that = this;

			eventsOnce[ pid++ ] = false;
			this.bind( pid + type, function() {
			   if ( !eventsOnce[ pid ] ) {
				   eventsOnce[ pid ] = true;
				   func.call( that );
			   }
			   that.unbind( pid + type );
			});
		}

		this.trigger = function( types ) {
			if ( !supported ) return this;

			var types = types.split( ' ' );

			for( var t = 0; t < types.length; t++ ) {
				var idx = types[ t ];

				for( var i = 0; i < events.length; i++ ) {
					var eventType = events[ i ].idx.split( '.' );
					if ( events[ i ].idx == idx || ( eventType[ 0 ] && eventType[ 0 ] == idx.replace( '.', '' ) ) ) {
						var evt = document.createEvent('HTMLEvents');
						evt.initEvent( eventType[ 0 ], false, true );
						this.sound.dispatchEvent( evt );
					}
				}
			}
			return this;
		}



		this.whenReady = function( func ) {
			if ( !supported ) return null;

			var that = this;
			if ( this.sound.readyState == 0 ) {
				this.bind( 'canplay.buzzwhenready', function() {
					func.call( that );
				});
			} else {
				func.call( that );
			}
		}

		// privates
		function timerangeToArray( timeRange ) {
			var array = [],
				length = timeRange.length - 1;

			for( var i = 0; i <= length; i++ ) {
				array.push({
					start: timeRange.start( length ),
					end: timeRange.end( length )
				});
			}
			return array;
		}

		function getExt( filename ) {
			return filename.split('.').pop();
		}

		function addSource( sound, src ) {
			var source = document.createElement( 'source' );
			source.src = src;
			if ( buzz.types[ getExt( src ) ] ) {
				source.type = buzz.types[ getExt( src ) ];
			}
			sound.appendChild( source );
		}

		// init
		if ( supported ) {

			for( i in buzz.defaults ) {
				options[ i ] = options[ i ] || buzz.defaults[ i ];
			}

			this.sound = document.createElement( 'audio' );

			if ( src instanceof Array ) {
				for( var i in src ) {
					addSource( this.sound, src[ i ] );
				}
			} else if ( options.formats.length ) {
				for( var i in options.formats ) {
					addSource( this.sound, src + '.' + options.formats[ i ] );
				}
			} else {
				addSource( this.sound, src );
			}

			if ( options.loop ) {
				this.loop();
			}

			if ( options.autoplay ) {
				this.sound.autoplay = 'autoplay';
			}

			if ( options.preload === true ) {
				this.sound.preload = 'auto';
			} else if ( options.preload === false ) {
				this.sound.preload = 'none';
			} else {
				this.sound.preload = options.preload;
			}

			this.setVolume( options.volume );

			buzz.sounds.push( this );
		}
	},

	all: function() {
	  return new buzz.group( buzz.sounds );
	},

	isSupported: function() {
		return !!this.el.canPlayType;
	},

	isOGGSupported: function() {
		return !!this.el.canPlayType && this.el.canPlayType( 'audio/ogg; codecs="vorbis"' );
	},

	isWAVSupported: function() {
		return !!this.el.canPlayType && this.el.canPlayType( 'audio/wav; codecs="1"' );
	},

	isMP3Supported: function() {
		return !!this.el.canPlayType && this.el.canPlayType( 'audio/mpeg;' );
	},


}
