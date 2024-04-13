<?php

use SplStack;

class UndoManager
{
    private $undoStack;
    private $redoStack;

    public function __construct()
    {
        $this->undoStack = new SplStack();
        $this->redoStack = new SplStack();
    }

    // 添加一个操作到历史记录
    public function add($operation)
    {
        $this->undoStack->push($operation);
        // 每次添加新操作时，清空重做栈
        $this->redoStack = new SplStack();
    }

    // 撤销上一个操作
    public function undo()
    {
        if (!$this->undoStack->isEmpty()) {
            $operation = $this->undoStack->pop();
            $this->redoStack->push($operation);
            return $operation;
        }
        return null;
    }

    // 重做上一个撤销的操作
    public function redo()
    {
        if (!$this->redoStack->isEmpty()) {
            $operation = $this->redoStack->pop();
            $this->undoStack->push($operation);
            return $operation;
        }
        return null;
    }

    // 清空历史记录
    public function clear()
    {
        $this->undoStack = new SplStack();
        $this->redoStack = new SplStack();
    }

    // 获取当前历史记录
    public function getHistory()
    {
        return iterator_to_array($this->undoStack);
    }
}

// 实例化 UndoManager 类
$undoManager = new UndoManager();

// 用户执行一些操作并添加到历史记录中
$undoManager->add("操作 1");
$undoManager->add("操作 2");
$undoManager->add("操作 3");
var_dump($undoManager->getHistory());
// 撤销上一个操作
$undoneOperation = $undoManager->undo();
echo "撤销: $undoneOperation\n";

// 重做上一个撤销的操作
$redoneOperation = $undoManager->redo();
echo "恢复: $redoneOperation\n";

var_dump($undoManager->getHistory());
