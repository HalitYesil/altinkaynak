<?php
/**
 * MIT License
 * Copyright (c) 2020 HalitYesil
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Altinkaynak\Response;

class Response{
	public function __construct($responseObject, $map = []){
		self::decorateResponse($responseObject, $map);
	}
	
	private function decorateResponse($responseObject, $map = []){
		if(is_object($responseObject)){
			foreach ($map as $k => $v) {
				if(isset($responseObject->{$k})){
					$responseValue = $responseObject->{$k};
					if(is_array($responseValue) && is_array($v) && !empty($v)){
						$this->{$v['param']} = [];
						foreach ($responseValue as $k2 => $item){
							$this->{$v['param']}[$k2] = new $v['class']($item);
						}
					}else if(is_object($responseValue) && is_array($v) && !empty($v)){
						if(isset($v['force_array']) && boolval($v['force_array'])){
							$this->{$v['param']} = [new $v['class']($responseValue)];
						}else{
							$this->{$v['param']} = new $v['class']($responseValue);
						}
					}else if(!is_array($v)){
						$this->{$v} = $responseObject->{$k};
					}else{
						$this->{$k} = $responseObject->{$k};
					}
				}
			}
		}
	}
}