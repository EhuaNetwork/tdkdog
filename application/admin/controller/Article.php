<?php


namespace app\admin\controller;

use app\index\mod\Mod;
use think\Db;
use Tool\Tree;

class Article extends Baseadmin
{
    public function lists($t=null,$k=null,$ip=null)
    {
        $data = db('article')->join('mod','mod.id=ecms_article.type');
        if(!empty($t)){
            $data=$data->where('type',$t);
        }
        if(!empty($k)){
            $data=$data->where('ecms_article.name','like',"%$k%")->whereOr('url','like',"%$k%");
        }
        if(!empty($ip)){
            $data=$data->where('server','=',$ip);
        }

        $data=$data->field('ecms_article.*,mod.name as type_name');

        $data = $data->join('run_log', 'run_log.id=ecms_article.log','left')
            ->field('ecms_article.*,run_log.t,run_log.d,run_log.k,run_log.create_time')
            ->order('error', 'desc')
            ->order('run_log.create_time', 'desc')
            ->order('id', 'desc')

            ->paginate(10, false, ['query' => request()->param()]);
        $render = $data->render();
        $this->assign('render', $render);
        $this->assign('data', $data);
        $ur=urlencode(request()->url());
        $this->assign('ur', $ur);







        $types = Db::name('mod')->order('top', '')->field('id,upid,name')->select();
        function sort($data, $pid = 0, $level = 0)
        {
            static $arr = array();
            foreach ($data as $k => $v) {
                if ($v['upid'] == $pid) {
                    $v['level'] = $level;
                    $arr[] = $v;
                    sort($data, $v['id'], $level + 1);
                }
            }
            return $arr;
        }

        $type2 = sort($types);
        $this->assign('type2', $type2);
        $this->assign('tt', $t);

        return view();
    }

    public function create($i=null)
    {
//        $ROOT = ROOT_PATH . 'public';
//        $path = ROOT_PATH . 'application' . DS . 'data' . DS . 'core' . DS . 'frpc';
//        $path2 = str_replace("\\", "\\\\", $path);
//        $ROOT2 = str_replace("\\", "\\\\", $ROOT);



        $this->assign('i', request()->param('i'));
        if (request()->isPost()) {

            $data = [
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s', time()),
            ];
            $data=array_merge($data,request()->param());
            $data['type']=$data['t'];

            unset($data['i']);
            unset($data['t']);
            if (Db::name('article')->insert( $data)) {


                $this->success('发布完成');
            } else {
                $this->error('发布失败');
            }
        } else {
            $types = Db::name('mod')->order('top', '')->field('id,upid,name')->select();
            function sort($data, $pid = 0, $level = 0)
            {
                static $arr = array();
                foreach ($data as $k => $v) {
                    if ($v['upid'] == $pid) {
                        $v['level'] = $level;
                        $arr[] = $v;
                        sort($data, $v['id'], $level + 1);
                    }
                }
                return $arr;
            }

            $type2 = sort($types);
            $this->assign('type2', $type2);
            return view();
        }

    }

    public function create2()
    {
        if (request()->isPost()) {
            $this->assign('i', request()->param('i'));

            $data = [
                'create_time' => date('Y-m-d H:i:s', time()),
                'update_time' => date('Y-m-d H:i:s', time()),
            ];

            $data=array_merge($data,request()->param());
            unset($data['i']);
            if (Db::name('article')->insert( $data)) {
                $this->success('发布完成');
            } else {
                $this->error('发布失败');
            }
        } else {
            $types = Db::name('mod')->order('top', '')->field('id,upid,name')->select();
            function sort($data, $pid = 0, $level = 0)
            {
                static $arr = array();
                foreach ($data as $k => $v) {
                    if ($v['upid'] == $pid) {
                        $v['level'] = $level;
                        $arr[] = $v;
                        sort($data, $v['id'], $level + 1);
                    }
                }
                return $arr;
            }

            $type2 = sort($types);
            $this->assign('type2', $type2);

            return view();
        }

    }

    public function edit($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }
        $res = Db::name('article')->where('id', $i)->find();
        if (empty($res)) {
            $this->error('数据不存在');
        }


        $this->assign('data', $res);
        return view();
    }

    public function update()
    {

        $id = request()->param('i');
        if (empty($id)) {
            $this->error('信息不完整');
        }
        $data= request()->param();

        $data = array_filter($data);
        unset($data['i']);
        if (Db::name('article')->where('id', $id)->update($data)) {
            echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
            $this->error('保存成功','/admin/article/lists.html');
        } else {
            $this->error('保存失败');
        }
    }

    public function del($i = null)
    {
        $arr = explode(',', $i);
        if (Db::name('article')->whereIn('id', $arr)->delete()) {
            $this->success('删除完成');
        } else {
            $this->error('删除失败');
        }
    }

    public function settype($i = null, $t = null)
    {
        $arr = explode(',', $i);
        if (Db::name('article')->whereIn('id', $arr)->update(['type' => $t])) {
            $this->success('移动完成');
        } else {
            $this->error('移动失败');
        }
    }
}