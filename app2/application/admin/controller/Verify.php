<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: ����� <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace org;
class Verify
{
    protected $config = [
        'seKey'    => 'ThinkPHP.CN', // ��֤�������Կ
        'codeSet'  => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', // ��֤���ַ�����
        'expire'   => 1800, // ��֤�����ʱ�䣨s��
        'useZh'    => false, // ʹ��������֤��
        'zhSet'    => '�����ҵ�������ʱҪ��������һ�ǹ�������巢�ɲ���ɳ��ܷ������˲����д�����������Ϊ����������ѧ�¼��ظ���ͬ����˵�ֹ����ȸ�����Ӻ������С��Ҳ�����߱������������ʵ�Ҷ������ˮ������������������ʮս��ũʹ��ǰ�ȷ���϶�·ͼ�ѽ�������¿���֮��ӵ���Щ�������¶�����������˼�����ȥ�����������ѹԱ��ҵ��ȫ�������ڵ�ƽ��������ëȻ��Ӧ�����������ɶ������ʱ�չ�������û���������ϵ������Ⱥͷ��ֻ���ĵ����ϴ���ͨ�����Ͽ��ֹ�����������ϯλ����������ԭ�ͷ�������ָ��������ںܽ̾��ش˳�ʯǿ�������Ѹ���ֱ��ͳʽת�����о���ȡ������������־�۵���ôɽ�̰ٱ��������汣��ί�ָĹܴ�������֧ʶ�������Ϲ�רʲ���;�ʾ������ÿ�����������Ϲ����ֿƱ�������Ƹ��������������༯������װ����֪���е�ɫ����ٷ�ʷ����������֯�������󴫿ڶϿ��ɾ����Ʒ�вβ�ֹ��������ȷ������״��������Ŀ����Ȩ�Ҷ����֤��Խ�ʰ��Թ�˹��ע�첼�����������ر��̳�������ǧʤϸӰ�ð׸�Ч���ƿ��䵶Ҷ������ѡ���»������ʼƬʩ���ջ�������������ҩ����Ѵ��ʿ���Һ��׼��ǽ�ά�������������״����ƶ˸������ش幹���ݷǸ���ĥ�������ʽ���ֵ��̬���ױ�������������̨���û������ܺ���ݺ����ʼ��������Ͼ��ݼ���ҳ�����Կ�Ӣ��ƻ���Լ�Ͳ�ʡ���������ӵ۽�����ֲ������������ץ���縱����̸Χʳ��Դ�������ȴ����̻����������׳߲��зۼ������濼�̿�������ʧ��ס��֦�־����ܻ���ʦ������Ԫ����ɰ�⻻̫ģƶ�����ｭ��Ķľ����ҽУ���ص�����Ψ�们վ�����ֹĸ�д��΢�Է�������ĳ�����������൹�������ù�Զ���Ƥ����ռ����Ȧΰ��ѵ�ؼ��ҽ��ƻ���������ĸ�����ֶ���˫��������ʴ����˿Ůɢ��������Ժ�䳹����ɢ�����������������Ѫ��ȱ��ò�����ǳ���������������̴���������������Ͷ��ū����ǻӾഥ�����ͻ��˶��ٻ����δͻ�ܿ���ʪƫ�Ƴ�ִ����կ�����ȶ�Ӳ��Ŭ�����Ԥְ������Э�����ֻ���ì������ٸ�������������ͣ����Ӫ�ո���Ǯ��������ɳ�˳��ַ�е�ذ����İ��������۵��յ���ѽ�ʰɿ��ֽ�������������ĩ������ڱ������������������𾪶ټ�����ķ��ɭ��ʥ���մʳٲ��ھؿ��������԰ǻ�����������������ӡ�伱�����˷�¶��Ե�������������Ѹ��������ֽҹ������׼�����ӳ��������ɱ���׼辧�尣ȼ��������ѿ��������̼��������ѿ����б��ŷ��˳������͸˾Σ������Ц��β��׳����������������ţ��Ⱦ�����������Ƽ�ֳ�����ݷô���ͭ��������ٺ�����Դ��ظ���϶¯����úӭ��ճ̽�ٱ�Ѯ�Ƹ�������Ը���������̾䴿������������³�෱�������׶ϣ�ذܴ�����ν�л��ܻ���ڹ��ʾ����ǳ���������Ϣ������������黭�������������躮ϲ��ϴʴ���ɸ���¼������֬ׯ��������ҡ���������������Ű²��ϴ�;�������Ұ�ž�ıŪ�ҿ�����ʢ��Ԯ���Ǽ���������Ħæ�������˽����������������Ʊܷ�������Ƶ�������Ҹ�ŵ����Ũ��Ϯ˭��л�ڽ���Ѷ���鵰�պ������ͽ˽������̹����ù�����ո��伨���ܺ���ʹ�������������ж�����׷���ۺļ���������о�Ѻպ��غ���Ĥƪ��פ������͹�ۼ���ѩ�������������߲��������ڽ������˹�̿������������ǹ���ð������Ͳ���λ�����Ϳζ����Ϻ�½�����𶹰�Ī��ɣ�·쾯���۱�����ɶ���ܼ��Ժ��浤�ɶ��ٻ���ϡ���������ǳӵѨ������ֽ����������Ϸ��������ò�����η��ɰ���������ˢ�ݺ���������©�������Ȼľ��з������Բ����ҳ�����ײ����ȳ����ǵ������������ɨ������оү���ؾ����Ƽ��ڿ��׹��ð��ѭ��ף���Ͼ����������ݴ���ι�������Ź�ó����ǽ���˽�ī������ж����������ƭ�ݽ�', // ������֤���ַ���
        'useImgBg' => false, // ʹ�ñ���ͼƬ
        'fontSize' => 25, // ��֤�������С(px)
        'useCurve' => true, // �Ƿ񻭻�������
        'useNoise' => true, // �Ƿ�����ӵ�
        'imageH'   => 0, // ��֤��ͼƬ�߶�
        'imageW'   => 0, // ��֤��ͼƬ���
        'length'   => 5, // ��֤��λ��
        'fontttf'  => '', // ��֤�����壬�����������ȡ
        'bg'       => [243, 251, 254], // ������ɫ
        'reset'    => true, // ��֤�ɹ����Ƿ�����
    ];
    private $_image = null; // ��֤��ͼƬʵ��
    private $_color = null; // ��֤��������ɫ
    /**
     * �ܹ����� ���ò���
     * @access public
     * @param  array $config ���ò���
     */
    public function __construct($config = [])
    {
        $this->config = array_merge($this->config, $config);
    }
    /**
     * ʹ�� $this->name ��ȡ����
     * @access public
     * @param  string $name ��������
     * @return multitype    ����ֵ
     */
    public function __get($name)
    {
        return $this->config[$name];
    }
    /**
     * ������֤������
     * @access public
     * @param  string $name ��������
     * @param  string $value ����ֵ
     * @return void
     */
    public function __set($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }
    /**
     * �������
     * @access public
     * @param  string $name ��������
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->config[$name]);
    }
    /**
     * ��֤��֤���Ƿ���ȷ
     * @access public
     * @param string $code �û���֤��
     * @param string $id ��֤���ʶ
     * @return bool �û���֤���Ƿ���ȷ
     */
    public function check($code, $id = '')
    {
        $key = $this->authcode($this->seKey) . $id;
        // ��֤�벻��Ϊ��
        $secode = session($key);
        if (empty($code) || empty($secode)) {
            return false;
        }
        // session ����
        if (time() - $secode['verify_time'] > $this->expire) {
            session($key, null);
            return false;
        }
        if ($this->authcode(strtoupper($code)) == $secode['verify_code']) {
            $this->reset && session($key, null);
            return true;
        }
        return false;
    }
    /**
     * �����֤�벢����֤���ֵ�����session��
     * ��֤�뱣�浽session�ĸ�ʽΪ�� array('verify_code' => '��֤��ֵ', 'verify_time' => '��֤�봴��ʱ��');
     * @access public
     * @param string $id Ҫ������֤��ı�ʶ
     * @return void
     */
    public function entry($id = '')
    {
        // ͼƬ��(px)
        $this->imageW || $this->imageW = $this->length * $this->fontSize * 1.5 + $this->length * $this->fontSize / 2;
        // ͼƬ��(px)
        $this->imageH || $this->imageH = $this->fontSize * 2.5;
        // ����һ�� $this->imageW x $this->imageH ��ͼ��
        $this->_image = imagecreate($this->imageW, $this->imageH);
        // ���ñ���
        imagecolorallocate($this->_image, $this->bg[0], $this->bg[1], $this->bg[2]);
        // ��֤�����������ɫ
        $this->_color = imagecolorallocate($this->_image, mt_rand(1, 150), mt_rand(1, 150), mt_rand(1, 150));
        // ��֤��ʹ���������
        $ttfPath = dirname(__FILE__) . '/verify/' . ($this->useZh ? 'zhttfs' : 'ttfs') . '/';
        if (empty($this->fontttf)) {
            $dir  = dir($ttfPath);
            $ttfs = [];
            while (false !== ($file = $dir->read())) {
                if ('.' != $file[0] && substr($file, -4) == '.ttf') {
                    $ttfs[] = $file;
                }
            }
            $dir->close();
            $this->fontttf = $ttfs[array_rand($ttfs)];
        }
        $this->fontttf = $ttfPath . $this->fontttf;
        if ($this->useImgBg) {
            $this->_background();
        }
        if ($this->useNoise) {
            // ���ӵ�
            $this->_writeNoise();
        }
        if ($this->useCurve) {
            // �������
            $this->_writeCurve();
        }
        // ����֤��
        $code   = []; // ��֤��
        $codeNX = 0; // ��֤���N���ַ�����߾�
        if ($this->useZh) {
            // ������֤��
            for ($i = 0; $i < $this->length; $i++) {
                $code[$i] = iconv_substr($this->zhSet, floor(mt_rand(0, mb_strlen($this->zhSet, 'utf-8') - 1)), 1, 'utf-8');
                imagettftext($this->_image, $this->fontSize, mt_rand(-40, 40), $this->fontSize * ($i + 1) * 1.5, $this->fontSize + mt_rand(10, 20), $this->_color, $this->fontttf, $code[$i]);
            }
        } else {
            for ($i = 0; $i < $this->length; $i++) {
                $code[$i] = $this->codeSet[mt_rand(0, strlen($this->codeSet) - 1)];
                $codeNX += mt_rand($this->fontSize * 1.2, $this->fontSize * 1.6);
                imagettftext($this->_image, $this->fontSize, mt_rand(-40, 40), $codeNX, $this->fontSize * 1.6, $this->_color, $this->fontttf, $code[$i]);
            }
        }
        // ������֤��
        $key                   = $this->authcode($this->seKey);
        $code                  = $this->authcode(strtoupper(implode('', $code)));
        $secode                = [];
        $secode['verify_code'] = $code; // ��У���뱣�浽session
        $secode['verify_time'] = time(); // ��֤�봴��ʱ��
        session($key . $id, $secode);
        header('Cache-Control: private, max-age=0, no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header("content-type: image/png");
        // ���ͼ��
        imagepng($this->_image);
        imagedestroy($this->_image);
    }
    /**
     * ��һ������������һ�𹹳ɵ�������Һ���������������(����Ըĳɸ�˧�����ߺ���)
     *
     *      ���е���ѧ��ʽզ����������д����
     *        �����ͺ�������ʽ��y=Asin(��x+��)+b
     *      ������ֵ�Ժ���ͼ���Ӱ�죺
     *        A��������ֵ������������ѹ���ı�����
     *        b����ʾ������Y���λ�ù�ϵ�������ƶ����루�ϼ��¼���
     *        �գ�����������X��λ�ù�ϵ������ƶ����루����Ҽ���
     *        �أ��������ڣ���С������T=2��/�O�بO��
     *
     */
    private function _writeCurve()
    {
        $px = $py = 0;
        // ����ǰ����
        $A = mt_rand(1, $this->imageH / 2); // ���
        $b = mt_rand(-$this->imageH / 4, $this->imageH / 4); // Y�᷽��ƫ����
        $f = mt_rand(-$this->imageH / 4, $this->imageH / 4); // X�᷽��ƫ����
        $T = mt_rand($this->imageH, $this->imageW * 2); // ����
        $w = (2 * M_PI) / $T;
        $px1 = 0; // ���ߺ�������ʼλ��
        $px2 = mt_rand($this->imageW / 2, $this->imageW * 0.8); // ���ߺ��������λ��
        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(��x+��) + b
                $i  = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color); // ����(while)ѭ�������ص��imagettftext��imagestring�������Сһ�λ�����������whileѭ��������Ҫ�úܶ�
                    $i--;
                }
            }
        }
        // ���ߺ󲿷�
        $A   = mt_rand(1, $this->imageH / 2); // ���
        $f   = mt_rand(-$this->imageH / 4, $this->imageH / 4); // X�᷽��ƫ����
        $T   = mt_rand($this->imageH, $this->imageW * 2); // ����
        $w   = (2 * M_PI) / $T;
        $b   = $py - $A * sin($w * $px + $f) - $this->imageH / 2;
        $px1 = $px2;
        $px2 = $this->imageW;
        for ($px = $px1; $px <= $px2; $px = $px + 1) {
            if (0 != $w) {
                $py = $A * sin($w * $px + $f) + $b + $this->imageH / 2; // y = Asin(��x+��) + b
                $i  = (int) ($this->fontSize / 5);
                while ($i > 0) {
                    imagesetpixel($this->_image, $px + $i, $py + $i, $this->_color);
                    $i--;
                }
            }
        }
    }
    /**
     * ���ӵ�
     * ��ͼƬ��д��ͬ��ɫ����ĸ������
     */
    private function _writeNoise()
    {
        $codeSet = '2345678abcdefhijkmnpqrstuvwxyz';
        for ($i = 0; $i < 10; $i++) {
            //�ӵ���ɫ
            $noiseColor = imagecolorallocate($this->_image, mt_rand(150, 225), mt_rand(150, 225), mt_rand(150, 225));
            for ($j = 0; $j < 5; $j++) {
                // ���ӵ�
                imagestring($this->_image, 5, mt_rand(-10, $this->imageW), mt_rand(-10, $this->imageH), $codeSet[mt_rand(0, 29)], $noiseColor);
            }
        }
    }
    /**
     * ���Ʊ���ͼƬ
     * ע�������֤�����ͼƬ�Ƚϴ󣬽�ռ�ñȽ϶��ϵͳ��Դ
     */
    private function _background()
    {
        $path = dirname(__FILE__) . '/verify/bgs/';
        $dir  = dir($path);
        $bgs = [];
        while (false !== ($file = $dir->read())) {
            if ('.' != $file[0] && substr($file, -4) == '.jpg') {
                $bgs[] = $path . $file;
            }
        }
        $dir->close();
        $gb = $bgs[array_rand($bgs)];
        list($width, $height) = @getimagesize($gb);
        // Resample
        $bgImage = @imagecreatefromjpeg($gb);
        @imagecopyresampled($this->_image, $bgImage, 0, 0, 0, 0, $this->imageW, $this->imageH, $width, $height);
        @imagedestroy($bgImage);
    }
    /* ������֤�� */
    private function authcode($str)
    {
        $key = substr(md5($this->seKey), 5, 8);
        $str = substr(md5($str), 8, 10);
        return md5($key . $str);
    }
}