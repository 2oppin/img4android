# img4android

Simple script that will create images of different sizes (scale factors):
```
drawable-xxxhdpi  ~  x1
drawable-xxhdpi   ~  x0.75
drawable-xhdpi    ~  x0.5
drawable-hdpi     ~  x0.375
drawable-tvdpi    ~  x0.3328
drawable-mdpi     ~  x0.25
drawable-ldpi     ~  x0.1875
```

```
Usage: php scale.php -f you_enormously_big_file.jpg -s 1024

-h --help	 - Display help
-f --file	 - Provide file to process
-d --dir	 - Provide directory to process
-s --size	 - Specify max desired size (width). Use carefully if you pass whole directory, in that case all images will have same size
```
