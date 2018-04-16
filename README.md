# 在线程序切片系统

## 安装

### 使用预构建的 Docker 镜像

首先拉取镜像，然后使用镜像运行容器。

```shell
docker pull sdygt/stitp
docker run -it -d -p 8000:80 sdygt/stitp
```
容器启动后，使用`http://127.0.0.1:8000`访问

其中，`8000`为在宿主机上的开放端口，可以按需修改

> 国内用户推荐使用[DaoCloud](https://www.daocloud.io/mirror)或[阿里云](https://dev.aliyun.com/)的免费镜像加速服务。具体使用方法请参见相关文档

### 自行构建 Docker 镜像

为了自行构建 Docker 镜像，您需要 Docker 17.05 以上的版本。

> Docker for Windows 由于依赖 Hyper-V 虚拟化技术，需要 Windows 10 专业版以上的版本

首先将repo的源码拉取到本地：

```shell
git clone --recurse-submodules https://github.com/sdygt/STITP.git
```

随后使用`docker build`命令在本地构建镜像：

```shell
cd STITP
docker build --tag sdygt/stitp .
```

其中`tag`参数可以按需指定。

构建完成后，使用此镜像创建容器并运行：

```shell
docker run -it -d -p 8000:80 --name stitp sdygt/stitp
```

`name`参数指定容器的名称，最后的参数指定使用镜像的`tag`，此处为`sdygt/stitp`

#### 为另一台机器构建镜像

如果希望为另一台机器（例如内网机器）构建镜像，可以在能访问互联网的机器上构建镜像后导出至另一台机器。

按上述说明直接拉取预构建镜像或自行构建镜像后，执行

```shell
docker image save sdygt/stitp > stitp.tar
```

将镜像打包为tar文件。

将`stitp.tar`复制到另一台机器以后，执行

```shell
docker image load -i stitp.tar
```

也可以使用`gzip`减小储存空间：

```shell
docker image save sdygt/stitp | gzip -c > stitp.tar.gz
docker image load -i stitp.tar.gz
```

