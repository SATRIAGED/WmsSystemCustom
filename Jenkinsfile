def appName = 'wms-system-custom'
def namespace = 'web'


pipeline {
    environment {
        registry = 'https://github.com/SATRIAGED/WmsSystemCustom.git'
    }

agent any
 stages {
     stage("Checkout code") {
         steps {
             checkout scm
         }
     }
     stage("Build image") {
         steps {
             script {
                 dockerImage = docker.build registry
             }
         }
     }
 stage("Deploy Kubernetes") {

     steps {
                 script {
     withKubeConfig([credentialsId: 'kubeconfig']) 
         {
       sh "kubectl apply -f deployment.yaml"
       sh "kubectl apply -f service.yaml"
       }                
     }
       //kubernetesDeploy(configs: "deployment.yml", "service.yml")
       }                
     }

   }
 }
