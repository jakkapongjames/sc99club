sjcl.hash.sha1=function(a){a?(this._h=a._h.slice(0),this._buffer=a._buffer.slice(0),this._length=a._length):this.reset()},sjcl.hash.sha1.hash=function(a){return(new sjcl.hash.sha1).update(a).finalize()},sjcl.hash.sha1.prototype={blockSize:512,reset:function(){return this._h=this._init.slice(0),this._buffer=[],this._length=0,this},update:function(a){"string"==typeof a&&(a=sjcl.codec.utf8String.toBits(a));var b,c=this._buffer=sjcl.bitArray.concat(this._buffer,a),d=this._length,e=this._length=d+sjcl.bitArray.bitLength(a);for(b=this.blockSize+d&-this.blockSize;b<=e;b+=this.blockSize)this._block(c.splice(0,16));return this},finalize:function(){var a,b=this._buffer,c=this._h;for(b=sjcl.bitArray.concat(b,[sjcl.bitArray.partial(1,1)]),a=b.length+2;15&a;a++)b.push(0);for(b.push(Math.floor(this._length/4294967296)),b.push(0|this._length);b.length;)this._block(b.splice(0,16));return this.reset(),c},_init:[1732584193,4023233417,2562383102,271733878,3285377520],_key:[1518500249,1859775393,2400959708,3395469782],_f:function(a,b,c,d){return a<=19?b&c|~b&d:a<=39?b^c^d:a<=59?b&c|b&d|c&d:a<=79?b^c^d:void 0},_S:function(a,b){return b<<a|b>>>32-a},_block:function(a){var b,c,d,e,f,g,h,i=a.slice(0),j=this._h;for(d=j[0],e=j[1],f=j[2],g=j[3],h=j[4],b=0;b<=79;b++)b>=16&&(i[b]=this._S(1,i[b-3]^i[b-8]^i[b-14]^i[b-16])),c=this._S(5,d)+this._f(b,e,f,g)+h+i[b]+this._key[Math.floor(b/20)]|0,h=g,g=f,f=this._S(30,e),e=d,d=c;j[0]=j[0]+d|0,j[1]=j[1]+e|0,j[2]=j[2]+f|0,j[3]=j[3]+g|0,j[4]=j[4]+h|0}};var hmacSHA1=function(a){var b=new sjcl.misc.hmac(a,sjcl.hash.sha1);this.encrypt=function(){return b.encrypt.apply(b,arguments)}};
window['hmacSHA1'] = hmacSHA1;
