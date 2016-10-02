<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2016/10/1
 * Time: 16:34
 */

namespace app\api\controller;


use think\Controller;

class Mock extends Controller
{
    public function AllVarAnalyze_Bwd()
    {
        $json = '{"Bwd": {"a@add": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "b@add": {"sum3.c": [9, 12, 13, 15, 27, 28, 33, 40, 41]}, "i@main": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "n@main": {"sum3.c": [9]}, "sum@main": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "tmp@inc": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "x@A": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "y@A": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "z@inc": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]} }, "Info": "Its trace Info: #Insts_bwdSym = 68\n Backward Static SliceTable:\n #Insts_sliced = 207.0 (Average: 23)\n Its some statistic Info.:\n #Defined_Functions = 4\n CFG(#Nodes,#Edges) = [\"main: (23,23)\",\"A: (8,7)\",\"add: (10,9)\",\"inc: (7,6)\"]\n #BasicBlocks = 7\n #Insts_All = 44\n #Insts_alloc = 10\n #Insts_br = 1\n #Vars_sliced = 9\n Its runtime = 4.8774e-2\n"}';
        return json(json_decode($json, true));
    }

    public function AllVarAnalyze_Fwd()
    {
        $json = '{"Fwd": {"a@add": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "b@add": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "i@main": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "n@main": { "sum3.c": [9, 13, 15, 18, 19, 27, 28, 33, 40, 41] }, "sum@main": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "tmp@inc": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "x@A": { "sum3.c": [18, 27, 33] }, "y@A": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "z@inc": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] } }, "Info": "Its trace Info: #Insts_Symbolic = 72\n Forward Static SliceTable:\n #Insts_sliced = 307.0 (Average: 34)\n Its some statistic Info.:\n #Defined_Functions = 4\n CFG(#Nodes,#Edges) = [\"main: (23,23)\",\"A: (8,7)\",\"add: (10,9)\",\"inc: (7,6)\"]\n #BasicBlocks = 7\n #Insts_All = 44\n #Insts_alloc = 10\n #Insts_br = 1\n #Vars_sliced = 9\n Its runtime = 7.3581e-2\n"}';
        return json(json_decode($json, true));
    }

    public function AllVarAnalyze_Both()
    {
        $json = '{"Bwd": {"a@add": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "b@add": {"sum3.c": [9, 12, 13, 15, 27, 28, 33, 40, 41]}, "i@main": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "n@main": {"sum3.c": [9]}, "sum@main": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "tmp@inc": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "x@A": {"sum3.c": [9, 11, 12, 13, 15, 27, 28, 33, 40, 41]}, "y@A": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]}, "z@inc": {"sum3.c": [9, 12, 13, 15, 28, 33, 40, 41]} },"Fwd": {"a@add": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "b@add": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "i@main": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "n@main": { "sum3.c": [9, 13, 15, 18, 19, 27, 28, 33, 40, 41] }, "sum@main": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "tmp@inc": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "x@A": { "sum3.c": [18, 27, 33] }, "y@A": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] }, "z@inc": { "sum3.c": [13, 15, 18, 19, 27, 28, 33, 40, 41] } }, "Info": "Its trace Info: #Insts_Symbolic = 72\n Forward Static SliceTable:\n #Insts_sliced = 307.0 (Average: 34)\n Its some statistic Info.:\n #Defined_Functions = 4\n CFG(#Nodes,#Edges) = [\"main: (23,23)\",\"A: (8,7)\",\"add: (10,9)\",\"inc: (7,6)\"]\n #BasicBlocks = 7\n #Insts_All = 44\n #Insts_alloc = 10\n #Insts_br = 1\n #Vars_sliced = 9\n Its runtime = 7.3581e-2\n"}';
        return json(json_decode($json, true));
    }

    public function SingleVarAnalyze()
    {
        $json = '{"BwdIR": "%n = alloca i32 , align 4\n %i = alloca i32 , align 4\n %4 = call i32 @__isoc99_scanf ( i8* i8* getelementptr ( [3 x i8]* @.str1 ,  i32 0, i32 0 ), i32* %n )\n store i32 1 , i32* %i , align 4\n %7 = phi i32 [ [%.pre, %10], [1, %0] ]\n %8 = load i32* %n , align 4\n %9 = icmp sle i32 %7 , %8\n br i1 %9 , label %10 , label %11\n call void @A ( i32* %sum, i32* %i )\n %.pre = load i32* %i , align 4\n i32* %y\n call void @inc ( i32* %y )\n i32* %a\n i32* %b\n %3 = load i32* %a , align 4\n %4 = load i32* %b , align 4\n %5 = add nsw i32 %3 , %4\n store i32 %5 , i32* %a , align 4\n i32* %z\n %tmp = alloca i32 , align 4\n store i32 1 , i32* %tmp , align 4\n call void @add ( i32* %z, i32* %tmp )\n", "FwdIR": "%i = alloca i32 , align 4\n %sum = alloca i32 , align 4\n %7 = phi i32 [ [%.pre, %10], [1, %0] ]\n %8 = load i32* %n , align 4\n %9 = icmp sle i32 %7 , %8\n br i1 %9 , label %10 , label %11\n call void @A ( i32* %sum, i32* %i )\n %.pre = load i32* %i , align 4\n %12 = load i32* %sum , align 4\n %13 = call i32 @printf ( i8* i8* getelementptr ( [10 x i8]* @.str2 ,  i32 0, i32 0 ), i32 %12 )\n %15 = load i32* %i , align 4\n %16 = call i32 @printf ( i8* i8* getelementptr ( [8 x i8]* @.str3 ,  i32 0, i32 0 ), i32 %15 )\n i32* %x\n i32* %y\n %1 = alloca i32* , align 8\n %2 = alloca i32* , align 8\n store i32* %x , i32** %1 , align 8\n store i32* %y , i32** %2 , align 8\n call void @add ( i32* %x, i32* %y )\n call void @inc ( i32* %y )\n i32* %a\n i32* %b\n %1 = alloca i32* , align 8\n %2 = alloca i32* , align 8\n store i32* %a , i32** %1 , align 8\n store i32* %b , i32** %2 , align 8\n %3 = load i32* %a , align 4\n %4 = load i32* %b , align 4\n %5 = add nsw i32 %3 , %4\n store i32 %5 , i32* %a , align 4\n i32* %z\n %1 = alloca i32* , align 8\n %tmp = alloca i32 , align 4\n store i32* %z , i32** %1 , align 8\n store i32 1 , i32* %tmp , align 4\n call void @add ( i32* %z, i32* %tmp )\n", "Info": "Its trace Info: #Insts_bwdSym = 68\n Its trace Info: #Insts_Symbolic = 72\n Its some statistic Info.:\n #Defined_Functions = 4\n CFG(#Nodes,#Edges) = [\"main: (23,23)\",\"A: (8,7)\",\"add: (10,9)\",\"inc: (7,6)\"]\n #BasicBlocks = 7\n #Insts_All = 44\n #Insts_alloc = 10\n #Insts_br = 1\n #Vars_sliced = 9\n Its runtime = 6.1216e-2\n"}';
        return json(json_decode($json, true));
    }
}