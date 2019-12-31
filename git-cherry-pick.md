# git-cherry-pick 简单实用

## 简介
git cherry-pick可以获取某一个分支的单笔或多笔commit，并作为一个新的提交引入到你当前分支上。 如果只想将某一次或某几次commit合入到本地当前分支上，那么就要使用git cherry-pick。

## 基本用法

```
$ git cherry-pick
usage: git cherry-pick [<options>] <commit-ish>...
   or: git cherry-pick <subcommand>

    --quit                退出当前的 chery-pick 序列
    --continue            继续当前的 chery-pick 序列
    --abort               取消当前的 chery-pick 序列
    -n, --no-commit       不自动提交
    -e, --edit            编辑提交信息
    -s, --signoff         添加签名人
```
合并单个commit：
```
$ git log
commit ee2cf51d71b48fecc2c26c52932cf4473f898a5f (HEAD -> master, origin/master, origin/HEAD)
Author: xiang.meng <xiang.meng@majorbio.com>
Date:   Tue Dec 31 13:06:05 2019 +0800

    'readme'

commit f7468cba05d7925f8744e1970cecf3b8491d734c
Author: mx <oscarmx0912@outlook.com>
Date:   Tue Dec 31 12:48:36 2019 +0800

    Rename wsl.md to WSL+Windows Terminal体验.md

commit a7aeecab1c6822aab8c601ee7228877152f85ca1
Author: mx <oscarmx0912@outlook.com>
Date:   Mon Dec 30 16:16:46 2019 +0800

    Update wsl.md

$ git cherry-pick <commit id>
```
指定你想要合并的那次提交commit id 即可，执行完 cherry-pick 以后，将会生成一个新的提交到本地当前分支，新的提交commit id和原来的不同，但标识名一样

合并多个commit，使用空格隔开commit id
```
$ git cherry-pick <commit id 1> <commit id 2>
```