<?php
    include_once "include/common/web.php";
    include_once "include/common/fun.php";

    class EasterEgg {
        public function Display() {
            $info2NextPage = new PassInfoBetweenPage();
            $info2NextPage->SetInfo(self::GetEgg(), self::$egg);
            Web::Jump2Web("/courseweb/easter_egg.php");
        }

        static public function GetEgg() {
            return "EasterEgg";
        }

        static private $egg = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                html, body {
                    height: 100%;
                    width:  100%;
                    margin: 0px;
                }
            </style>
        </head>
        <body>
            <object width = \"100%\" height = \"100%\" data = \"data/dessert.swf\"></object>
        </body>
        </html>";

        static private $egg1 = "
            <!DOCTYPE html>
            <html>
                <style>.c {margin :1px;width:19px;height:19px;background:red;position:absolute;}
                    .d {margin :1px;width:19px;height:19px;background:gray;position:absolute;}
                    .f {top:0px;left:0px;background:black;position:absolute;}
                </style>
                <body></body>
            </html>
            <script>
                var over=false,shapes=(\"0,1,1,1,2,1,3,1;1,0,1,1,1,2,2,2;2,0,2,1,2,2,1,2;0,1,1,1,1,2,2,2;1,2,2,2,2,1,3,1;1,1,2,1,1,2,2,2;0,2,1,2,1,1,2,2\").split(\";\");
                function create(tag,css){
                    var elm=document.createElement(tag);
                    elm.className = css;
                    document.body.appendChild(elm);
                    return elm;
                }
                function Tetris(c, t, x, y){
                    var c=c?c:\"c\";
                    this.divs = [create(\"div\",c),create(\"div\",c),create(\"div\",c),create(\"div\",c)];
                    this.reset = function(){
                        this.x = typeof x != 'undefined'?x:3;
                        this.y = typeof y != 'undefined'?y:0;
                        this.shape = t?t:shapes[Math.floor(Math.random()*(shapes.length-0.00001))].split(\",\");
                        this.show();
                        if(this.field&&this.field.check(this.shape,this.x,this.y,'v')=='D'){
                            over=true;
                            this.field.fixShape(this.shape,this.x,this.y);
                            alert('game over');
                        }
                    }
                    this.show = function(){
                        for(var i in this.divs){
                            this.divs[i].style.left = (this.shape[i*2]*1+this.x)*20+'px';
                            this.divs[i].style.top = (this.shape[i*2+1]*1+this.y)*20+'px';
                        }
                    }
                    this.field=null;
                    this.hMove = function(step){
                        var r = this.field.check(this.shape,this.x- -step,this.y,'h');
                        if(r!='N'&&r==0){
                            this.x-=-step;
                            this.show();
                        }
                    }
                    this.vMove = function(){
                        if(this.field.check(this.shape,this.x,this.y- -1,'v')=='N'){
                            this.y++;
                            this.show();
                        } else{
                            this.field.fixShape(this.shape,this.x,this.y);
                            this.field.findFull();
                            this.reset();
                        }
                    }
                    this.rotate = function(){
                        var s=this.shape;
                        var newShape=[3-s[1],s[0],3-s[3],s[2],3-s[5],s[4],3-s[7],s[6]];
                        var r = this.field.check(newShape,this.x,this.y,'h');
                        if(r=='D')return;
                        if(r==0){
                            this.shape=newShape;
                            this.show();
                        } else if(this.field.check(newShape,this.x-r,this.y,'h')==0){
                            this.x-=r;
                            this.shape=newShape;
                            this.show();
                        }
                    }
                    this.reset();
                }

                function Field(w,h) {
                    this.width = w?w:10;
                    this.height = h?h:20;
                    this.show = function(){
                        var f = create(\"div\",\"f\")
                        f.style.width=this.width*20+'px';
                        f.style.height=this.height*20+'px';
                    }
                    this.findFull = function(){
                        for(var l=0;l<this.height;l++){
                            var s=0;
                            for(var i=0;i<this.width;i++){
                                s+=this[l*this.width+i]?1:0;
                            }
                            if(s==this.width){
                                this.removeLine(l);
                            }
                        }
                    }
                    this.removeLine = function(line){
                        for(var i=0;i<this.width;i++){
                            document.body.removeChild(this[line*this.width+i]);
                        }
                        for(var l=line;l>0;l--){
                            for(var i=0;i<this.width;i++){
                                this[l*this.width- -i]=this[(l-1)*this.width- -i];
                                if(this[l*this.width- -i])this[l*this.width- -i].style.top = l*20+'px';
                            }
                        }
                    }
                    this.check = function(shape, x, y, d){
                        var r1=0,r2='N';
                        for(var i=0;i<8;i+=2){
                            if(shape[i]- -x < 0 && shape[i]- -x <r1) {
                                r1 = shape[i]- -x;
                            } else if(shape[i]- -x>=this.width && shape[i]- -x>r1) {
                                r1 = shape[i]- -x;
                            }
                            if(shape[i+1]- -y>=this.height || this[shape[i]- -x- -(shape[i+1]- -y)*this.width]) {
                                r2='D';
                            }
                        }
                        if(d=='h'&&r2=='N')return r1>0?r1-this.width- -1:r1;
                        else return r2;
                    }
                    this.fixShape = function(shape,x,y){
                        var d=new Tetris(\"d\",shape,x,y);
                        d.show();
                        for(var i=0;i<8;i+=2){
                            this[shape[i]- -x- -(shape[i+1]- -y)*this.width]=d.divs[i/2];
                        }
                    }
                }
                var f = new Field();
                f.show();
                var s = new Tetris();
                s.field = f;
                s.show();
                window.setInterval(\"if(!over)s.vMove();\",500);
                document.onkeydown = function(e){
                    if(over)return;
                    var e = window.event ? window.event : e;
                    switch(e.keyCode) {
                        case 38: //up
                            s.rotate();
                            break;
                        case 40: //down
                            s.vMove();
                            break;
                        case 37: //left
                            s.hMove(-1);
                            break;
                        case 39: //right
                            s.hMove(1);
                            break;
                    }
                }
            </script>";
        static private $egg2 = "
            <!doctype html>
            <html>
            <body>
                <canvas id=\"c\"></canvas>
                <script>
                    eval('Z f(e){g=g?q.createElement(\"canvas\"):q.body.children.c;g.width=e*100;g.height=c;a=g.getContext(\"2d\");r.push(g);for(b in a)a[(b[7]||b[0])+b[b[2].charCodeAt(0)%b.length]]=a[b]}Z m(e,n,o){a.sv();a.rotate(o);a.tt(0,-e);a.sa(n,n);o=l;l*=n;s();a.restore();l=o}Z s(){if(l>.04)if(d(1)<.04){m(0,.7,-.15);m(0,.7,.15)}else{a.tR(0,0,9,9);m(4,1,d(1)<.5?.08:-.08)}}Z d(e){return t.random()*e}Z h(e){a.fillStyle=e}var a,g,q=document,t=Math,r=[],w=\"#FFF\",c=400,p=i=0,l=1,b=f(9),j=a;f(9);k=a;h(w);f(9);u=a;h(\"rgba(0,0,0,.05)\");f(10);for(h(w);i++<200;)a.tR(d(1E3),d(c),d(3),d(3));f(15);b=a.ar(c,120,20,c,120,900);b.P=b.addColorStop;b.P(.1,w);b.P(.11,\"rgba(255,255,255,.3)\");b.P(1,\"rgba(4,129,227,0)\");h(b);a.tR(0,0,1500,c);f(20);h(\"#002b57\");for(a.tt(c,c);p++<4;a.tt(c,0))s();setInterval(Z(){j.ce(0,0,900,c);j.gg(k.cn,0,0);k.ce(0,0,900,c);k.gg(j.cn,-1,1);u.tR(0,0,900,c);u.gg(k.cn,0,0);d(1)<.03&&k.tR(d(1E3),0,d(3),d(3));j.tR(0,0,900,c);for(i=1;++i<6;)j.gg(b=r[i],t.abs(p%2-1)*-(b.width-900),0);p+=.0010},10)'.replace(/Z/g,'function'))
                </script>
            </body>
            </html>";
    }
?>
