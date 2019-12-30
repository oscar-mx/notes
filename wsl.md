# WSL+Windows Terminal (Preview)
> 闲来无事，折腾下win10linux子系统和最新版的Windows Terminal 命令行工具

## 1.下载linux发行版
微软官方提供了下载链接，下载你喜欢的发行版即可。
[点击直达](https://docs.microsoft.com/zh-cn/windows/wsl/install-manual)

## 2.安装LxRunOffline
LxRunOffline用于管理Windows Linux子系统（WSL）。
[了解更多](https://github.com/DDoSolitary/LxRunOffline)
Windows系统直接下载最新的releases版本安装即可，解压后将解压的文件安装路径加入到环境变量中，打开cmd输入LxRunOffline，若提示[ERROR] No action is specified.和命令帮助文档，则表示LxRunOffline安装成功。

## 3. 安装WSL
1.首先以管理员身份打开cmd或者PowerShell并运行：
Enable-WindowsOptionalFeature -Online -FeatureName Microsoft-Windows-Subsystem-Linux
出现提示时重新启动计算机，这一步未开启Linux子系统服务支持，当然也可以在系统设置-启用或关闭Windows功能里找到它。

2.解压之前下载的Linux发行版压缩包。

3.打开cmd或者PowerShell，输入LxRunOffline i -n <安装名称> -d <安装路径> -f <安装文件>
其中安装名称可以自定义，安装路径为自定义安装路径，安装文件为上一步解压后的文件中的install.tar.gz的路径，回车后等待安装完成，然后在cmd中输入wsl即可启动系统。

## 3. Windows Terminal
打开应用商店直接搜索Windows Terminal即可安装，需要18362或更高版本。
打开以后直观上和PowerShell没有什么不同，看来需要自己美化啊！
点击settings 设置defaultProfile值为wsl系统的值即可默认启动wslxi子系统命令行。
[了解更多](https://github.com/microsoft/terminal/blob/master/doc/user-docs/index.md)
